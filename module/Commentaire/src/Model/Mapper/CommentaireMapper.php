<?php
namespace Commentaire\Model\Mapper;

use Commentaire\Model\Commentaire as Comment;

/**
 * Class CommentaireMapper
 * @package Commentaire\Model\Mapper
 */
class CommentaireMapper
{
    /**
     * CommentaireMapper constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $data
     * @return Comment
     */
    public function exchangeArray($data) {

        $comment = new Comment();

        if (isset($data['commentaire_id'])) {
            $comment->setId($data['commentaire_id']);
        }
        if (isset($data['commentaire_row1'])) {
            $comment->setRow1($data['commentaire_row1']);
        }
        if (isset($data['commentaire_row2'])) {
            $comment->setRow2($data['commentaire_row2']);
        }
        if (isset($data['commentaire_row3'])) {
            $comment->setRow3($data['commentaire_row3']);
        }
        if (isset($data['commentaire_row4'])) {
            $comment->setRow4($data['commentaire_row4']);
        }
        if (isset($data['commentaire_msg'])) {
            $comment->setMessage($data['commentaire_msg']);
        }
        if (isset($data['commentaire_position'])) {
            $comment->setRang($data['commentaire_position']);
        }
        if (isset($data['commentaire_type'])) {
            $comment->setType($data['commentaire_type']);
        }
        if (isset($data['commentaire_date'])) {
            $comment->setDate($data['commentaire_date']);
        }
        if (isset($data['commentaire_contenuid'])) {
            $comment->setContenuId($data['commentaire_contenuid']);
        }
        if (isset($data['commentaire_status'])) {
            $comment->setCommentaireStatut($data['commentaire_status']);
        }

        return $comment;

    }
}