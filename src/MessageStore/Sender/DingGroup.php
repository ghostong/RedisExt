<?php

namespace Lit\RedisExt\MessageStore\Sender;

use Lit\RedisExt\MessageStore\Mapper\MessageGroupMapper;
use Lit\RedisExt\MessageStore\Mapper\SenderDingMapper;

class DingGroup extends Ding
{
    public static function text(array $messages, array $senders) {
        $data["msgtype"] = __FUNCTION__;
        $content = "";
        $atMobiles = $atUserIds = $isAtAll = [];
        foreach ($messages as $key => $messageGroupMapper) {
            /** @var MessageGroupMapper $messageGroupMapper */
            $content .= $messageGroupMapper->title . "\n" . $messageGroupMapper->body . "\n\n";
            /** @var SenderDingMapper $senderDingMapper */
            $senderDingMapper = $senders[$key];
            if (property_exists($senderDingMapper, "atMobiles")) {
                $atMobiles = array_merge($atMobiles, $senderDingMapper->atMobiles);
            }
            if (property_exists($senderDingMapper, "atUserIds")) {
                $atUserIds = array_merge($atUserIds, $senderDingMapper->atUserIds);
            }
            if (property_exists($senderDingMapper, "isAtAll")) {
                $isAtAll = array_merge($isAtAll, [$senderDingMapper->isAtAll]);
            }
        }
        $data["at"]["atMobiles"] = $atMobiles;
        $data["at"]["atUserIds"] = $atUserIds;
        $data["at"]["isAtAll"] = array_sum($isAtAll) > 0;
        $data["text"]["content"] = trim($content, "\n");
        /** @var SenderDingMapper $senderDingMapper */
        $senderDingMapper = $senders[count($senders) - 1];
        self::request($data, $senderDingMapper->accessToken, $senderDingMapper->token);
    }

    public static function markdown($messages, $senders) {
        $data["msgtype"] = __FUNCTION__;
        $title = $content = "";
        $atMobiles = $atUserIds = $isAtAll = [];
        foreach ($messages as $key => $messageGroupMapper) {
            /** @var MessageGroupMapper $messageGroupMapper */
            $content .= $messageGroupMapper->title . "\n" . $messageGroupMapper->body . "\n\n";
            /** @var SenderDingMapper $senderDingMapper */
            $senderDingMapper = $senders[$key];
            if (property_exists($senderDingMapper, "atMobiles")) {
                $atMobiles = array_merge($atMobiles, $senderDingMapper->atMobiles);
            }
            if (property_exists($senderDingMapper, "atUserIds")) {
                $atUserIds = array_merge($atUserIds, $senderDingMapper->atUserIds);
            }
            if (property_exists($senderDingMapper, "isAtAll")) {
                $isAtAll = array_merge($isAtAll, [$senderDingMapper->isAtAll]);
            }
            $title = $messageGroupMapper->title;
        }
        $data["at"]["atMobiles"] = $atMobiles;
        $data["at"]["atUserIds"] = $atUserIds;
        $data["at"]["isAtAll"] = array_sum($isAtAll) > 0;
        $data["markdown"]["text"] = trim($content, "\n");
        $data["markdown"]["title"] = $title;
        /** @var SenderDingMapper $senderDingMapper */
        $senderDingMapper = $senders[count($senders) - 1];
        self::request($data, $senderDingMapper->accessToken, $senderDingMapper->token);
    }

    public static function link($messages, $senders) {
        $data["msgtype"] = __FUNCTION__;

    }

    public static function feedCard($message, $sender) {
        $data["msgtype"] = __FUNCTION__;

    }

    public static function actionCard($message, $sender) {
        $data["msgtype"] = __FUNCTION__;

    }

}