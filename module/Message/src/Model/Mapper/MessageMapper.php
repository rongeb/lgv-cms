<?php

namespace Message\Model\Mapper;

use Message\Model\Message;

/**
 * Class MessageMapper
 * @package Message\Model\Mapper
 */
class MessageMapper
{
    /**
     * MessageMapper constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $data (array)
     * @return Message
     */
    public function exchangeArray($data) {

        $message = new Message();

        if (isset($data['message_id'])) {
            $message->setId($data['message_id']);
        }
        if (isset($data['message_row1'])) {
            $message->setRow1($data['message_row1']);
        }
        if (isset($data['message_row2'])) {
            $message->setRow2($data['message_row2']);
        }
        if (isset($data['message_row3'])) {
            $message->setRow3($data['message_row3']);
        }
        if (isset($data['message_row4'])) {
            $message->setRow4($data['message_row4']);
        }
        if (isset($data['message_msg'])) {
            $message->setMessage($data['message_msg']);
        }
        /*
        if (isset($data['message_position'])) {
            $message->setRang($data['message_position']);
        }
         *
         */
        if (isset($data['message_type'])) {
            $message->setType($data['message_type']);
        }
        if (isset($data['message_date'])) {
            $message->setDate($data['message_date']);
        }

        return $message;
    }

    public function exchangeForm($data) {

        $message = new Message();

        if (isset($data['id'])) {
            $message->setId($data['id']);
        }
        if (isset($data['row1'])) {
            $message->setRow1($data['row1']);
        }
        if (isset($data['row2'])) {
            $message->setRow2($data['row2']);
        }
        if (isset($data['row3'])) {
            $message->setRow3($data['row3']);
        }
        if (isset($data['row4'])) {
            $message->setRow4($data['row4']);
        }
        if (isset($data['msg'])) {
            $message->setMessage($data['msg']);
        }
        if (isset($data['type'])) {
            $message->setType($data['type']);
        }
        if (isset($data['position'])) {
            $message->setRang($data['position']);
        }
        if (isset($data['timestamp'])) {
            $message->setDate($data['timestamp']);
        }

        return $message;
    }
}