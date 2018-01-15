<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 */

namespace iPaya\DingTalk\Api;

/**
 * About document see https://open-doc.dingtalk.com/docs/doc.htm?treeId=257&articleId=105735&docType=1
 *
 * @package iPaya\DingTalk\Api
 */
class Robot extends Api
{
    private $accessToken;

    /**
     * @param string $accessToken
     * @return self
     */
    public function configure($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return string
     */
    protected function getUrl()
    {
        return '/robot/send?' . http_build_query(['access_token' => $this->accessToken]);
    }

    /**
     * @param string $content
     * @param string|array $at
     * @return array|string
     */
    public function sendText($content, $at = null)
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
            ]
        ];
        if ($at == '*') {
            $data['at']['atMobiles'] = $at;
            $data['at']['isAtAll'] = true;
        } elseif (is_array($at)) {
            $data['at']['atMobiles'] = $at;
            $data['at']['isAtAll'] = false;
        }

        return $this->postJson($this->getUrl(), $data);
    }

    /**
     * 发送 Link 消息
     *
     * @param string $title
     * @param string $content
     * @param string $url
     * @param string|null $picUrl
     * @return array|string
     */
    public function sendLink(string $title, string $content, string $url, string $picUrl = null)
    {
        $data = [
            'msgtype' => 'link',
            'link' => [
                'text' => $content,
                'title' => $title,
                'messageUrl' => $url,
                'picUrl' => $picUrl,
            ]
        ];
        return $this->postJson($this->getUrl(), $data);
    }

    /**
     * @param string $title
     * @param string $content
     * @param string|array $at
     * @return array|string
     */
    public function sendMarkdown(string $title, string $content, $at = null)
    {
        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $content,
            ]
        ];

        if ($at == '*') {
            $data['at']['atMobiles'] = $at;
            $data['at']['isAtAll'] = true;
        } elseif (is_array($at)) {
            $data['at']['atMobiles'] = $at;
            $data['at']['isAtAll'] = false;
        }

        return $this->postJson($this->getUrl(), $data);
    }

    /**
     * 发送整体跳转的 ActionCard
     *
     * @param string $title
     * @param string $content
     * @param string $singleTitle
     * @param string $url
     * @param bool $hideAvatar
     * @return array|string
     */
    public function sendSingleActionCard(string $title, string $content, string $singleTitle, string $url, bool $hideAvatar = false)
    {
        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $content,
                'singleTitle' => $singleTitle,
                'singleURL' => $url,
                'hideAvatar' => $hideAvatar ? '1' : '0',
            ]
        ];

        return $this->postJson($this->getUrl(), $data);
    }

    /**
     * 发送独立跳转的 ActionCard
     *
     * @param string $title
     * @param string $content
     * @param array $buttons
     * @param bool $hideAvatar
     * @param int $btnOrientation
     * @return array|string
     */
    public function sendActionCard(string $title, string $content, array $buttons, bool $hideAvatar = false, $btnOrientation = 0)
    {
        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $content,
                'hideAvatar' => $hideAvatar ? '1' : '0',
                'btnOrientation' => $btnOrientation,
            ]
        ];
        foreach ($buttons as $btnTitle => $btnUrl) {
            $btn = [
                'title' => $btnTitle,
                'actionURL' => $btnUrl,
            ];
            $data['actionCard']['btns'][] = $btn;
        }

        return $this->postJson($this->getUrl(), $data);
    }

    /**
     * 发送 FeedCard
     *
     * @param array $links
     * @return array|string
     */
    public function sendFeedCard(array $links)
    {
        $data = [
            'msgtype' => 'feedCard',
        ];
        foreach ($links as $link) {
            $data['feedCard'][] = [
                'title' => $link['title'],
                'messageURL' => $link['url'],
                'picURL' => $link['picUrl'],
            ];
        }
        return $this->post($this->getUrl(), $data);
    }
}
