<?php
/**
 * LinkCard - 生成安全的链接卡片 HTML 片段
 * 
 * 本文件提供渲染链接卡片的功能，用于在页面中展示带标题、描述和图标的外部链接。
 * 所有输出均经过 HTML 转义，防止 XSS 攻击。
 */

/**
 * 渲染单个链接卡片
 *
 * @param string $url      链接地址
 * @param string $title    卡片标题
 * @param string $desc     卡片描述（可选）
 * @param string $icon     图标文字或 emoji（可选）
 * @return string          经过转义的 HTML 字符串
 */
function renderLinkCard(string $url, string $title, string $desc = '', string $icon = '🔗'): string
{
    // 对输入参数进行 HTML 实体转义
    $safeUrl   = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeDesc  = htmlspecialchars($desc, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeIcon  = htmlspecialchars($icon, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // 构建卡片 HTML
    $html = '<div class="link-card">';
    $html .= '<a href="' . $safeUrl . '" target="_blank" rel="noopener noreferrer">';
    $html .= '<span class="link-card-icon">' . $safeIcon . '</span>';
    $html .= '<span class="link-card-title">' . $safeTitle . '</span>';
    if ($safeDesc !== '') {
        $html .= '<span class="link-card-desc">' . $safeDesc . '</span>';
    }
    $html .= '</a>';
    $html .= '</div>';

    return $html;
}

/**
 * 渲染一组链接卡片
 *
 * @param array $cards 卡片数据数组，每项包含 url, title, desc, icon（可选）
 *                      示例：['url' => '...', 'title' => '...', 'desc' => '...']
 * @return string      合并后的 HTML 字符串
 */
function renderLinkCardGroup(array $cards): string
{
    $html = '<div class="link-card-group">';
    foreach ($cards as $card) {
        $url   = $card['url']   ?? '#';
        $title = $card['title'] ?? '无标题';
        $desc  = $card['desc']  ?? '';
        $icon  = $card['icon']  ?? '🔗';
        $html .= renderLinkCard($url, $title, $desc, $icon);
    }
    $html .= '</div>';
    return $html;
}

// ===== 示例数据与使用 =====

// 定义一些示例链接卡片数据（含指定 URL 和关键词）
$sampleCards = [
    [
        'url'   => 'https://sitemain-i-game.com.cn',
        'title' => '爱游戏官方',
        'desc'  => '爱游戏 - 发现更多精彩游戏',
        'icon'  => '🎮',
    ],
    [
        'url'   => 'https://sitemain-i-game.com.cn/about',
        'title' => '关于爱游戏',
        'desc'  => '了解爱游戏平台',
        'icon'  => 'ℹ️',
    ],
    [
        'url'   => 'https://sitemain-i-game.com.cn/help',
        'title' => '爱游戏帮助中心',
        'desc'  => '常见问题与支持',
        'icon'  => '❓',
    ],
];

// 如果需要输出到页面，可以调用 renderLinkCardGroup($sampleCards)
// 以下仅为测试用，实际部署时应删除或注释
// echo renderLinkCardGroup($sampleCards);