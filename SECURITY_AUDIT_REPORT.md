# PunBB 1.4.6 中文版 安全审计报告

> **审计日期**: 2026-07-15  
> **审计范围**: `/home/zemi/MyDev/punbb-1.4.6-chinese` 全部 PHP 源文件（156+ 个文件）  
> **审计维度**: SQL 注入、XSS/输出编码、认证授权、会话管理、文件上传、路径遍历、信息泄露、配置安全  

---

## 执行摘要

本项目是一个基于纯过程式 PHP 的轻量论坛程序（PunBB 1.4.6），已移植至 PHP 8.4+。整体代码在输出编码（`forum_htmlencode()`）和 SQL 转义（`$forum_db->escape()`）方面表现出较好的安全意识，但存在若干**高风险**遗留问题，主要集中在：

1. **密码学陈旧**: 使用双 SHA1 哈希存储密码，无 bcrypt/argon2
2. **会话/Cookie 安全不足**: 无速率限制、Cookie 中泄露密码哈希、会话固定风险
3. **关键脚本无身份验证**: `admin/db_update.php` 可被任意未认证用户访问
4. **数据库文件暴露**: SQLite 数据库文件位于 Web 可访问目录，无保护
5. **Host 头注入**: 未验证的 `$_SERVER['HTTP_HOST']` 可导致全站 URL 劫持

---

## 发现汇总

| 编号    | 问题                                     | 严重程度  | 类别        |
| ----- | -------------------------------------- | ----- | --------- |
| H-01  | `admin/db_update.php` 无身份验证 + 强制 DEBUG | 🔴 极高 | 配置/访问控制   |
| H-02  | SQLite 数据库文件位于 Web 可访问目录               | 🔴 极高 | 配置/信息泄露   |
| H-03  | 密码使用 SHA1 双哈希（非 bcrypt/argon2）         | 🔴 高  | 认证        |
| H-04  | "记住我" Cookie 中泄露密码哈希                   | 🔴 高  | 会话/Cookie |
| H-05  | 缺少登录速率限制                               | 🔴 高  | 认证        |
| H-06  | 缺少 CAPTCHA/验证码                         | 🔴 高  | 认证        |
| H-07  | 密码重置密钥仅 8 字符（~47.8 位熵）                 | 🔴 高  | 认证        |
| H-08a | 存储型 XSS — 公告消息未编码                      | 🔴 高  | XSS       |
| H-08b | 存储型 XSS — 论坛规则消息未编码                    | 🔴 高  | XSS       |
| H-08c | 存储型 XSS — 维护模式消息未编码                    | 🔴 高  | XSS       |
| H-08d | 存储型 XSS — 论坛描述未编码                      | 🔴 高  | XSS       |
| H-08e | 开放重定向 — 重定向论坛 `Location` 头             | 🔴 高  | URL/重定向   |
| H-08  | Host Header 注入（`$base_url` 劫持）         | 🔴 高  | XSS/URL   |
| H-09  | Cookie Secure 标志未设置                    | 🔴 高  | 会话/Cookie |
| H-10  | 启用 `FORUM_SHOW_QUERIES` 时泄露所有 SQL      | 🔴 高  | 信息泄露      |
| M-01  | `FORUM_DEBUG` 模式泄露完整 SQL 错误            | 🟡 中  | 信息泄露      |
| M-02  | `query_build()` 架构无集中防御                | 🟡 中  | SQL 注入    |
| M-03  | `$_SERVER['HTTP_X_ORIGINAL_URL']` 未消毒  | 🟡 中  | XSS/URL   |
| M-04  | `get_current_url()` 使用未消毒 Server 变量    | 🟡 中  | XSS/URL   |
| M-05  | `rewrite.php` 双重 URL 解码风险              | 🟡 中  | XSS/路径    |
| M-06  | `eval($hook)` 设计——DB 写入即可 RCE          | 🟡 中  | 代码执行      |
| M-07  | 密码重置密钥无过期时间                            | 🟡 中  | 认证        |
| M-08  | 会话 ID 通过 GET 参数接受                      | 🟡 中  | 会话固定      |
| M-09  | 登录后未重新生成会话 ID                          | 🟡 中  | 会话固定      |
| M-10  | 缺少 SameSite Cookie 属性                  | 🟡 中  | 会话/Cookie |
| M-11  | Cookie 中密码哈希每次请求刷新                     | 🟡 中  | 会话/Cookie |
| M-12  | `config.php` 位于 Web root               | 🟡 中  | 配置        |
| M-13  | 头像上传 MIME 类型检查依赖客户端值                   | 🟡 中  | 文件上传      |
| M-14  | `o_avatars_dir` 配置项未过滤路径穿越             | 🟡 中  | 路径遍历      |
| M-15  | 邮件模板语言路径从 DB 读取未过滤                     | 🟡 中  | 路径遍历      |
| M-16  | `admin/` 和 `db/` 目录缺少 `index.html`     | 🟡 中  | 信息泄露      |
| M-17  | CSRF 令牌 URL 依赖 Server 变量一致性            | 🟡 中  | CSRF      |
| M-18  | 登出 CSRF 检查逻辑可优化                        | 🟡 中  | CSRF      |
| M-19  | 缓存文件 Include 执行（间接风险）                  | 🟡 中  | 代码执行      |
| L-01  | LIKE 通配符 `_` 未转义（可盲测数据）                | 🟢 低  | SQL 注入    |
| L-02  | `userlist.php` ORDER BY 仅白名单（无转义）      | 🟢 低  | SQL 注入    |
| L-03  | 分页参数缺少 `intval()`                      | 🟢 低  | SQL 注入    |
| L-04  | `add_user()` 中 `group_id` 未转义          | 🟢 低  | SQL 注入    |
| L-05  | `viewforum.php` 重定向 URL 可被管理员利用        | 🟢 低  | 开放重定向     |
| L-06  | `rewrite.php` 错误页面输出 REQUEST_URI       | 🟢 低  | XSS（已缓解）  |
| L-07  | 密钥比较非定时安全                              | 🟢 低  | 侧信道       |
| L-08  | `random_key()` 存在模数偏差（使用 mt_rand）      | 🟢 低  | 密码学       |
| L-09  | 管理员邮箱在 OpenSearch 中暴露                  | 🟢 低  | 信息泄露      |
| L-10  | `install.php` 仅检查 config.php 存在性       | 🟢 低  | 配置        |

---

## 一、认证与授权

### H-03: 密码使用 SHA1 双哈希

**文件**: `include/functions.php:1256-1263`、`login.php:54`

```php
function forum_hash($str, $salt) {
    return sha1($salt.sha1($str));
}
// login.php: 还兼容 32 字符的 MD5 哈希
$sha1_in_db = (strlen($db_password_hash) == 40) ? true : false;
```

**风险**: 现代 GPU 每秒可计算数十亿次 SHA1，即使有盐值也能被快速暴力破解。系统还向后兼容 MD5 哈希。

**修复**: 迁移至 `password_hash(PASSWORD_BCRYPT)` / `password_verify()`，对旧哈希实现透明升级策略。

---

### H-04: "记住我" Cookie 中泄露密码哈希

**文件**: `login.php:117-118`

```php
$expire = ($save_pass) ? time() + 1209600 : time() + $forum_config['o_timeout_visit'];
forum_setcookie($cookie_name, base64_encode($user_id.'|'.$form_password_hash.'|'.$expire.'|'.sha1(...)), $expire);
```

**风险**: Cookie 明文存储 `sha1($salt.sha1($password))`。Cookie 被窃取后，攻击者可直接获得密码哈希并离线破解。Cookie 有效期长达 14 天。更改密码不会使旧 Cookie 失效。

**修复**: 实现独立的随机 "remember token"，与密码哈希分离存储在数据库中，设置过期时间，提供"使所有会话失效"功能。

---

### H-05: 缺少登录速率限制

**文件**: `login.php:28-124`

登录过程完全没有速率限制、账户锁定或渐进式延迟。攻击者可无限次尝试暴力破解密码。

**修复**: 在 `users` 表添加 `login_attempts`、`last_login_attempt` 字段，连续失败 5 次锁定 15 分钟。

---

### H-06: 缺少 CAPTCHA/验证码

**文件**: `register.php:113-123`

仅通过 IP 地址限制每小时每 IP 注册一次，无 reCAPTCHA/hCaptcha 等验证码保护。绕过成本极低（僵尸网络、动态 IP）。

**修复**: 集成 Google reCAPTCHA v3 或 hCaptcha（为方便可使用静态图片加花验证码）。

---

### H-07: 密码重置密钥弱

**文件**: `login.php:253`、`include/functions.php:1222-1227`

```php
$new_password_key = random_key(8, true);
// random_key 使用 mt_rand() + 62 字符字母表 → 约 47.8 位熵
```

8 字符密钥仅提供 ~47.8 位熵，且使用 `mt_rand()` 存在模数偏差。可被暴力破解。

**修复**: 最少 32 字符随机密钥（192 位熵），设置 1 小时过期时间。

---

### H-01: `admin/db_update.php` 无身份验证

**文件**: `admin/db_update.php:28-51`

```php
// 该脚本直接包含 constants 和 functions，不经 common.php/common_admin.php
require FORUM_ROOT.'include/constants.php';
require FORUM_ROOT.'include/functions.php';
// 无任何身份验证检查！
// 第44-48行还强制启用 FORUM_DEBUG
if (!defined('FORUM_DEBUG'))
    define('FORUM_DEBUG', 1);
error_reporting(E_ALL);
```

**风险**: **任意用户** 可访问此 URL，触发数据库升级逻辑，且在 DEBUG 模式下会暴露完整 SQL 错误信息。

**修复**: 引入 `common.php` 和 `common_admin.php`，验证 `$forum_user['g_id'] == FORUM_ADMIN`。

---

## 二、会话与 Cookie 安全

### H-09: Cookie Secure 标志未设置

**文件**: `config.php:16`

```php
$cookie_secure = 0;
```

认证 Cookie 在 HTTP 明文连接中传输，存在网络嗅探风险。

**修复**: 生产环境使用 HTTPS 时设置 `$cookie_secure = 1`。

---

### M-08: 会话 ID 通过 GET 参数接受

**文件**: `include/functions.php:48-52`

```php
if (isset($_COOKIE['PHPSESSID']))
    $forum_session_id = $_COOKIE['PHPSESSID'];
else if (isset($_GET['PHPSESSID']))
    $forum_session_id = $_GET['PHPSESSID'];
```

攻击者可构造 `?PHPSESSID=KNOWNID` 的链接实施会话固定攻击。

**修复**: 移除 GET 参数接受，使用 `session.use_only_cookies=1`。

---

### M-09: 登录后未重新生成会话 ID

**文件**: `include/functions.php:66-70, 1334-1475`

会话 ID 仅在首次初始化时重新生成，`cookie_login()` 成功认证后未调用 `session_regenerate_id(true)`。

**修复**: 在 `cookie_login()` 成功后调用 `session_regenerate_id(true)`。

---

### M-10: 缺少 SameSite Cookie 属性

**文件**: `include/functions.php:220`

```php
setcookie($name, $value, $expire, $cookie_path, $cookie_domain, $cookie_secure, true);
```

`HttpOnly` 已设置，但缺 `SameSite` 属性（需用 `samesite` 选项或手动追加）。

**修复**: 使用 `['samesite' => 'Lax']` 选项。

---

## 三、SQL 注入

### 架构概述

项目使用自研查询构建器（`$forum_db->query_build()`），无参数化查询/预处理语句。所有 SQL 通过字符串拼接构建，转义责任完全由调用方承担。四个数据库驱动均正确实现了 `escape()` 方法，但**无集中防御机制**。

### M-02: `query_build()` 架构无集中防御

**文件**: `include/dblayer/*.php` 所有驱动的 `query_build()` 方法

数组值直接拼接到 SQL 中，无任何自动转义：

```php
if (!empty($query['WHERE']))
    $sql .= ' WHERE '.$query['WHERE'];
```

任何一次遗漏 `$forum_db->escape()` 的调用都可能导致 SQL 注入。在 156+ 个 PHP 文件中手工审计的成本极高。

**修复**: 考虑迁移至预处理语句，或至少添加集中转义回调机制。定期自动化审计所有 `query_build()` 调用。

---

### L-01: LIKE 通配符注入

**文件**: `include/search_functions.php:105,160`、`userlist.php:45`、`admin/users.php:925`

```php
'WHERE' => 'w.word LIKE \''.$forum_db->escape(str_replace('*', '%', $cur_word)).'\''
```

`$forum_db->escape()` 正确转义了字符串定界符，但 `_` 未被转义。攻击者可利用 `_`（单字符通配符）逐个字符探测数据。

**修复**: 使用 `addcslashes($value, '%_')` 或在 LIKE 中使用 `ESCAPE` 子句。

---

### L-02: ORDER BY 注入（白名单）

**文件**: `userlist.php:36-37, 234`

```php
'ORDER BY' => $forum_page['sort_by'].' '.$forum_page['sort_dir'].', u.id ASC',
```

变量来自 `$_GET`，但通过三元运算符限制为 `username/registered/num_posts` 和 `ASC/DESC`。目前安全，但扩展代码可能绕过白名单。

**修复**: 添加显式 `in_array()` 校验。

---

## 四、XSS 与输出安全

### 好消息

`forum_htmlencode()`（使用 `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')`）在大部分表单输出中**一致且正确**使用。BBCode 解析前的预编码架构（先 `forum_htmlencode()` 再 `do_bbcode()`）是有效的纵深防御。

但存在若干**管理员配置值的存储型 XSS**：这些值由管理员在后台设置，存入数据库后在前端输出时**未经过 `forum_htmlencode()` 编码**。

### H-08a: 存储型 XSS — 公告消息（Announcement）

**文件**: `header.php:178`

```php
$gen_elements['<!-- forum_announcement -->'] = ...
    '<h1 class="hn"><span>'.$forum_config['o_announcement_heading'].'</span></h1>'
    .'<div class="content">'.$forum_config['o_announcement_message'].'</div>';
```

`o_announcement_heading` 和 `o_announcement_message` 直接输出到 HTML，未编码。该值来自后台设置（`admin/settings.php:161-162`），仅在保存时调用了 `forum_linebreaks()`。**每个页面**都会渲染公告（若启用）。

**修复**: 对两个值应用 `forum_htmlencode()`。

---

### H-08b: 存储型 XSS — 论坛规则消息

**文件**: `register.php:75`、`misc.php:56`

```php
<?php echo $forum_config['o_rules_message'] ?>
```

注册页和独立规则页均直接输出 `o_rules_message`，未编码。同样来自后台设置（`admin/settings.php:182`），仅做 `forum_linebreaks()`。

**修复**: 对 `o_rules_message` 应用 `forum_htmlencode()`。

---

### H-08c: 存储型 XSS — 维护模式消息

**文件**: `include/functions.php:3121, 3169`

```php
$message = str_replace($pattern, $replace, $forum_config['o_maintenance_message']);
// ... 后续直接 echo 到 HTML
```

维护模式消息从数据库读出后仅做空白替换就直接输出。**所有访问者**在维护模式下都会收到注入的 payload。

**修复**: 对 `o_maintenance_message` 应用 `forum_htmlencode()`。

---

### H-08d: 存储型 XSS — 论坛描述

**文件**: `index.php:134-135, 178-179`

```php
$forum_page['item_subject']['desc'] = $cur_forum['forum_desc'];
```

论坛描述（`forum_desc`）从数据库取出后未经编码直接渲染到首页论坛列表。管理员在 `admin/forums.php:299` 设置时仅做 `forum_linebreaks()` + `forum_trim()`。

**修复**: 对 `forum_desc` 应用 `forum_htmlencode()`。

---

### H-08e: 开放重定向 — 重定向论坛

**文件**: `viewforum.php:66`

```php
header('Location: '.$cur_forum['redirect_url']);
```

`redirect_url` 从数据库取出后直接用于 HTTP `Location` 头，无验证。管理员可设置任意外部 URL，配合 CSRF 可实施钓鱼攻击。

**修复**: 验证 URL 必须以 `http://` 或 `https://` 开头，或实施白名单/代理重定向。

---

### H-08: Host Header 注入 — `$base_url` 劫持

**文件**: `include/essentials.php:110`

```php
$base_url_guess = ((isset($_SERVER['HTTPS']) ...) ? 'https://' : 'http://')
    .preg_replace('/:80$/', '', $_SERVER['HTTP_HOST'])
    .str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
```

`$_SERVER['HTTP_HOST']` 完全由客户端 `Host` 请求头控制。唯一消毒仅是剥离 `:80` 端口。攻击者可设置 `Host: evil.com`，使**全站所有链接和表单**指向恶意域名。

**注意**: 当前部署 `config.php` 中硬编码了 `$base_url`，故只在未设置时走此逻辑。但这是强潜在漏洞。

**修复**: 对 `$_SERVER['HTTP_HOST']` 做白名单验证，或至少剥离非字母数字字符。

---

### M-03: `$_SERVER['HTTP_X_ORIGINAL_URL']` 未消毒

**文件**: `include/functions.php:188-189`

```php
if (isset($_SERVER['HTTP_X_ORIGINAL_URL']))
    $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
```

IIS 常用的 `X-Original-URL` 头被直接赋值给 `$_SERVER['REQUEST_URI']`，未经任何消毒。这会流入 `get_current_url()` → 重定向 URL、CSRF 确认表单、`prev_url`。

**修复**: 消毒后再赋值，或完全移除对该头的支持。

---

### M-05: 双重 URL 解码

**文件**: `rewrite.php:38, 69, 71`

```php
$request_uri = substr(urldecode($_SERVER['REQUEST_URI']), ...);
$_REQUEST[$param_data[0]] = urldecode($param_data[1]);
$_GET[$param_data[0]] = urldecode($param_data[1]);
```

`urldecode()` 可产生绕过输入过滤器的字符（如双重编码 `%2561` → `%61` → `a`）。

**修复**: 使用 `rawurldecode()` 后再验证，或解码后值通过输入过滤器。

---

## 五、文件上传与路径遍历

### M-13: 头像上传 MIME 类型检查

**文件**: `profile.php:1142`

```php
if (!in_array($uploaded_file['type'], $allowed_mime_types))
```

`$_FILES['req_file']['type']` 来自 HTTP 客户端，可被任意伪造。好消息是后续 `getimagesize()` 提供了真正的类型验证。

**修复**: 移除客户端 MIME 检查，或保留但不依赖其结果（当前已有 `getimagesize()` 作为真正防线）。

---

### M-14: 头像目录路径可配置

**文件**: `admin/settings.php:118-119`

```php
if (substr($form['avatars_dir'], -1) == '/')
    $form['avatars_dir'] = substr($form['avatars_dir'], 0, -1);
```

`o_avatars_dir` 仅去尾部斜杠，未过滤 `../`。管理员若被入侵可设置任意路径。

**修复**: 添加 `preg_replace('#[\.\\\/]#', '', ...)` 过滤。

---

### M-06: `eval($hook)` 扩展钩子系统

全代码库约 300+ 处：

```php
($hook = get_hook('xxx')) ? eval($hook) : null;
```

钩子代码来自 `extension_hooks` 数据库表，通过 `eval()` 执行。任何能写入该表的人都可获得全站 RCE。扩展卸载时的 `eval($ext_data['uninstall'])` 同理。

**修复**: 考虑将钩子代码限制为回调函数名而非原始 PHP 代码。至少添加审计日志。

---

## 六、信息泄露与配置安全

### H-02: SQLite 数据库可被 Web 直接下载

**文件**: `db/punbb.sqlite3`

数据库文件位于 `db/` 目录下，该目录无 `index.html`、无 `.htaccess` 拒绝规则。若 Web 服务器启用目录列表或攻击者猜到文件名，可直接下载整个数据库（含用户密码哈希、邮箱、私信等）。

**修复**: 

1. 立即添加 `db/.htaccess`：`Deny from all`
2. 将数据库文件移出 Web root
3. 添加 `db/index.html`

---

### H-10: `FORUM_SHOW_QUERIES` 暴露所有 SQL

**文件**: `footer.php:87-88`、`include/functions.php:724-774`

当 `FORUM_SHOW_QUERIES` 常量被定义时，`get_saved_queries()` 在 HTML 表格中打印**每个请求的所有原始 SQL**。

**修复**: 添加仅管理员可见的角色检查；或用 IP 白名单限制。

---

### M-01: `FORUM_DEBUG` 模式泄露 SQL 错误

**文件**: `include/functions.php:3443-3451`

```php
if (defined('FORUM_DEBUG'))
{
    echo '<p>...数据库报告：</strong> '.$db_error['error_msg']...;
    echo '<p>...失败查询：</strong> <code>'.$db_error['error_sql'].'</code></p>';
}
```

**修复**: 对 SQL 输出做脱敏处理，或限制仅管理员可见。

---

### M-12: `config.php` 位于 Web root

`config.php` 包含数据库凭据、Cookie 密钥等敏感信息，虽已加入 `.gitignore`，但仍位于 Web 可访问目录中。

**修复**: 将配置移出 Web root；或添加 `.htaccess` 规则禁止直接访问。

---

## 七、积极发现

以下方面代码实现正确，值得肯定：

1. **`forum_htmlencode()` 一致性**: 所有表单输出均使用 `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')` 编码
2. **BBCode 解析管线**: `parse_message()` 先 HTML 编码再 BBCode 解析，实现有效纵深防御
3. **数据库 Escape 机制**: 四个数据库驱动的 `escape()` 方法均正确实现
4. **管理页面权限检查**: 所有 `admin/*.php` 页面均验证 `$forum_user['is_admmod']` 或 `g_id == FORUM_ADMIN`
5. **文件上传类型验证**: `getimagesize()` 提供真正的图像类型检测
6. **语言/样式参数过滤**: 语言和样式选择使用 `preg_replace('#[\.\\\/]#', '')` 防止路径穿越
7. **模板 Include 限制**: `forum_include` 正则 `/^[^/\\\\]*?/` 防止目录穿越
8. **头像目录 .htaccess**: `img/avatars/.htaccess` 正确限制仅允许图像文件
9. **缓存目录 .htaccess**: `cache/.htaccess` 正确拒绝 HTTP 访问
10. **根目录 .htaccess**: `Options -Indexes` 禁用目录列表

---

## 修复优先级建议

### 立即（极高+高风险）

| 优先级 | 编号      | 问题                                    | 预计改动量    |
| --- | ------- | ------------------------------------- | -------- |
| P0  | H-01    | `admin/db_update.php` 添加身份验证          | ~10 行    |
| P0  | H-02    | `db/` 目录添加 `.htaccess` + `index.html` | 新建 2 个文件 |
| P1  | H-03    | 密码哈希迁移至 bcrypt/argon2                 | ~30 行    |
| P1  | H-04    | 修复"记住我" token 机制                      | ~50 行    |
| P1  | H-08a~d | 管理员配置值输出编码（公告/规则/维护/描述）               | ~10 行    |
| P1  | H-08e   | 重定向论坛 URL 验证                          | ~5 行     |
| P1  | H-08    | 验证 `$_SERVER['HTTP_HOST']`            | ~5 行     |
| P1  | H-10    | `FORUM_SHOW_QUERIES` 添加权限检查           | ~5 行     |

### 尽快（中风险）

| 优先级 | 编号   | 问题                       |
| --- | ---- | ------------------------ |
| P2  | H-05 | 添加登录速率限制                 |
| P2  | H-06 | 添加 CAPTCHA               |
| P2  | H-07 | 增强密码重置密钥                 |
| P2  | H-09 | 启用 Cookie Secure 标志      |
| P2  | M-08 | 移除 GET 参数接受会话 ID         |
| P2  | M-09 | 登录后重新生成会话 ID             |
| P2  | M-03 | 消毒 `HTTP_X_ORIGINAL_URL` |
| P2  | M-14 | 过滤 `o_avatars_dir` 路径穿越  |

### 计划内（低风险/架构改进）

| 优先级 | 编号        | 问题                                |
| --- | --------- | --------------------------------- |
| P3  | M-02      | `query_build()` 架构加固              |
| P3  | L-01      | LIKE 通配符转义                        |
| P3  | M-05      | `urldecode()` 改为 `rawurldecode()` |
| P3  | M-12      | `config.php` 移出 Web root          |
| P3  | L-03~L-04 | 分页参数 `intval()` 等防御性改进            |

---

## 附录：数据库 Escape 机制覆盖

| 驱动            | 文件                                  | Escape 方法                   | 状态  |
| ------------- | ----------------------------------- | --------------------------- | --- |
| MySQLi        | `include/dblayer/mysqli.php`        | `mysqli_real_escape_string` | ✅   |
| MySQLi InnoDB | `include/dblayer/mysqli_innodb.php` | `mysqli_real_escape_string` | ✅   |
| PostgreSQL    | `include/dblayer/pgsql.php`         | `pg_escape_string`          | ✅   |
| SQLite3       | `include/dblayer/sqlite3.php`       | `SQLite3::escapeString`     | ✅   |

---

> **审计工具**: Claude Code 多代理并行审计  
> **审计代理**: SQL注入审计 / XSS审计 / 认证授权审计 / 文件上传审计 / 信息泄露审计  
