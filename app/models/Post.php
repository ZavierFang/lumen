<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Cache;

class Post extends Model
{

	public function __construct()
	{

	}

	protected $table = 'm_posts';

	function getpost($id)
	{
		$post = $this
			->select('post_title', 'id', 'post_content', 'created_at', 'post_keywords', 'post_description')
			->find($id);
		$post->post_keywords = $post->post_keywords == '' ? $post->post_title : $post->post_keywords;
		$content = mb_ereg_replace(' ', "\n", (strip_tags($post->post_content)));
		$content = strlen($content) > 30 ? mb_substr($content, 0, 30, 'UTF-8') . '...' : $content;
		$post->post_description = $post->post_description == '' ? $content : $post->post_description;
		$imgarr = getImgs($post->post_content);
		if (count($imgarr) > 0) {
		}
		Cache::put('post'.$id, $post,10);
		return $post;
	}

	function GetListPost($input = '')
	{
		$res = $this;
		if ($input != '') {
			$res = $this->where('post_title', 'like', '%' . $input . '%')
				->orWhere('post_content', 'like', '%' . $input . '%');
		}
		$res = $res->whereRaw('post_status = 1 AND post_type = "post"')
			->select('id', 'post_title', 'post_content', 'created_at')
			->orderBy('created_at', 'desc')
			->paginate(5);//分页
		$res->words = $input;
		return $res;
	}

	/**
	 * 获取所有文章，后台调用
	 * @param array $input
	 * @return mixed
	 */
	function GetAllPost($input = array())
	{
		$res['data'] = $this
			//->select('id','post_title','post_status','created_at')
			->orderBy('created_at', 'desc')
			->skip($input['start'])->take($input['limit'])->get();
		$res['total'] = $this->count();
		return $res;
	}

	/*
     * 更新或者添加文章没有ID是为新增，有ID时为更新
     * */
	function update_post($data = array())
	{
		if ($data['id'] == '') {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->insert($data);
		} else {
			if ($this->where('id', $data['id'])->update($data)) {
				return Cache::forget('post' . $data['id']);
			}
			return false;
		}
	}
}