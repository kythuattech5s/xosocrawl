<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Forum;
use basiccomment\comment\Models\Comment;

class CommentCrawler extends BaseCrawler
{
    public function startCrawl()
    {
        $listForumCrawl = Forum::act()->where('is_crawl',1)->get();
        foreach ($listForumCrawl as $itemForumCrawl) {
            $this->crawlCommentForum($itemForumCrawl);
        }
        return true;
    }
    public function crawlCommentForum($itemForumCrawl)
    {
        $countItem = 0;
        $listComment = $this->exeCurl($itemForumCrawl->crawl_comment_link);
        $arrCommentCrawl = \Support::extractJson($listComment);
        while (count($arrCommentCrawl) > 0 && isset($arrCommentCrawl['data']) && isset($arrCommentCrawl['data']['comments']) && $countItem < 500) {
            $status = $this->saveComment($arrCommentCrawl['data']['comments']);
            $countItem += count($arrCommentCrawl['data']['comments']);
            if (!$status) {
                return;
            }
        }
    }
    public function saveComment($arrComments)
    {
        foreach ($arrComments as $itemComment) {
            // $oldUser = 

            // $newComment = new Comment();
            // $newComment->
        }
    }
}
