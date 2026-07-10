<?php

// Language definitions for frequently used strings
$lang_common = array(

// Text orientation and encoding
'lang_direction'			=>	'ltr',	// ltr (Left-To-Right) or rtl (Right-To-Left)
'lang_identifier'			=>	'zh',

// Number formatting
'lang_decimal_point'		=>	'.',
'lang_thousands_sep'		=>	',',

// Notices
'Bad request'				=>	'错误请求。您访问的链接不正确或已过期。',
'No view'					=>	'您没有权限查看这些版块。',
'No permission'				=>	'您没有权限访问此页面。',
'CSRF token mismatch'		=>	'无法确认安全令牌。这通常是因为您打开页面的时间与提交表单的时间间隔过长。如果您希望继续操作，请点击"确认"按钮。否则请点击"取消"按钮返回。',
'No cookie'					=>	'您似乎已成功登录，但 Cookie 未被设置。请检查您的浏览器设置，并确保启用本网站的 Cookie。',


// Miscellaneous
'Forum index'				=>	'论坛首页',
'Submit'					=>	'提交',	// "name" of submit buttons
'Cancel'					=>	'取消', // "name" of cancel buttons
'Preview'					=>	'预览',	// submit button to preview message
'Delete'					=>	'删除',
'Split'						=>	'拆分',
'Ban message'				=>	'您已被禁止访问本论坛。',
'Ban message 2'				=>	'禁令将于 %s 结束。',
'Ban message 3'				=>	'禁止您的管理员或版主留下了以下信息：',
'Ban message 4'				=>	'如有任何疑问，请联系论坛管理员：%s。',
'Never'						=>	'从未',
'Today'						=>	'今天',
'Yesterday'					=>	'昨天',
'Forum message'				=>	'论坛消息',
'Maintenance warning'		=>	'<strong>警告！%s 已启用。</strong>请勿登出，否则您将无法再次登录。',
'Maintenance mode'			=>	'维护模式',
'Redirecting'				=>	' 正在跳转…', // With space!
'Forwarding info'			=>	'页面将在 %1$s %2$s 后自动跳转。',
'second'					=>	'秒',	// singular
'seconds'					=>	'秒',	// plural
'Click redirect'			=>	'如果您不想继续等待（或您的浏览器未自动跳转），请点击这里',
'Invalid e-mail'			=>	'您输入的电子邮件地址无效。',
'New posts'					=>	'新帖子',	// the link that leads to the first new post
'New posts title'			=>	'查找自您上次访问以来包含新帖子的主题。',	// the popup text for new posts links
'Active topics'				=>	'活跃主题',
'Active topics title'		=>	'查找包含近期帖子的主题。',
'Unanswered topics'			=>	'未回复主题',
'Unanswered topics title'	=>	'查找尚未被回复的主题。',
'Username'					=>	'用户名',
'Registered'				=>	'注册时间',
'Write message'				=>	'撰写内容',
'Forum'						=>	'版块',
'Posts'						=>	'帖子',
'Pages'						=>	'页',
'Page'						=>	'页',
'BBCode'					=>	'BBCode',	// You probably shouldn't change this
'Smilies'					=>	'表情',
'Images'					=>	'图片',
'You may use'				=>	'您可以使用：%s',
'and'						=>	'和',
'Image link'				=>	'图片',	// This is displayed (i.e. <image>) instead of images when "Show images" is disabled in the profile
'wrote'						=>	'写道',	// For [quote]'s (e.g., User wrote:)
'Code'						=>	'代码',	// For [code]'s
'Forum mailer'				=>	'%s 邮件系统',	// As in "MyForums Mailer" in the signature of outgoing e-mails
'Write message legend'		=>	'撰写您的帖子',
'Required information'		=>	'必填信息',
'Reqmark'					=>	'*',
'Required warn'				=>	'提交表单前必须填写所有加粗标记的字段。',
'Crumb separator'			=>	' &rarr;&#160;', // The character or text that separates links in breadcrumbs
'Title separator'			=>	' — ',
'Page separator'			=>	'&#160;', //The character or text that separates page numbers
'Spacer'					=>	'…', // Ellipsis for paginate
'Paging separator'			=>	' ', //The character or text that separates page numbers for page navigation generally
'Previous'					=>	'上一页',
'Next'						=>	'下一页',
'Cancel redirect'			=>	'操作已取消。',
'No confirm redirect'		=>	'未提供确认。操作已取消。',
'Please confirm'			=>	'请确认：',
'Help page'					=>	'帮助：%s',
'Re'						=>	'Re:',
'Page info'					=>	'（第 %1$s 页，共 %2$s 页）',
'Item info single'			=>	'%s：%s',
'Item info plural'			=>	'%s：第 %2$s 至 %3$s 项，共 %4$s 项', // e.g. Topics [ 10 to 20 of 30 ]
'Info separator'			=>	' ', // e.g. 1 Page | 10 Topics
'Powered by'				=>	'由 %s 提供技术支持，%s 提供服务。',
'Maintenance'				=>	'维护',
'Installed extension'		=>	'%s 官方扩展已安装。Copyright &copy; 2003&ndash;'.date('Y').' <a href="https://punbb.informer.com/">PunBB</a>。',
'Installed extensions'		=>	'当前已安装 <span id="extensions-used" title="%s">%s 个官方扩展</span>。Copyright &copy; 2003&ndash;2012 <a href="https://punbb.informer.com/">PunBB</a>。',

// CSRF confirmation form
'Confirm'					=>	'确认',	// Button
'Confirm action'			=>	'确认操作',
'Confirm action head'		=>	'请确认或取消您刚才的操作',

// Title
'Title'						=>	'头衔',
'Member'					=>	'成员',	// Default title
'Moderator'					=>	'版主',
'Administrator'				=>	'管理员',
'Banned'					=>	'被禁用户',
'Guest'						=>	'游客',

// Stuff for include/parser.php
'BBCode error 1'			=>	'[/%1$s] 没有与之匹配的 [%1$s]',
'BBCode error 2'			=>	'[%s] 标签为空',
'BBCode error 3'			=>	'[%1$s] 不能在 [%2$s] 内部打开',
'BBCode error 4'			=>	'[%s] 不能嵌套在自身内部',
'BBCode error 5'			=>	'[%s] 没有与之匹配的 [/%s]',
'BBCode error 6'			=>	'[%s] 标签的属性部分为空',
'BBCode nested list'		=>	'[list] 标签不能嵌套使用',
'BBCode code problem'		=>	'您的 [code] 标签存在问题',

// Stuff for the navigator (top of every page)
'Index'						=>	'首页',
'User list'					=>	'用户列表',
'Rules'						=>	'规则',
'Search'					=>	'搜索',
'Register'					=>	'注册',
'register'					=>	'注册',
'Login'						=>	'登录',
'login'						=>	'登录',
'Not logged in'				=>	'您尚未登录。',
'Profile'					=>	'个人资料',
'Logout'					=>	'退出',
'Logged in as'				=>	'当前登录用户：%s。',
'Admin'						=>	'管理',
'Last visit'				=>	'上次访问：%s',
'Mark all as read'			=>	'标记所有主题为已读',
'Login nag'					=>	'请登录或注册。',
'New reports'				=>	'新举报',

// Alerts
'New alerts'				=>	'新通知',
'Maintenance alert'			=>	'<strong>维护模式已启用。</strong><em>请勿</em>登出，否则您将无法再次登录。',
'Updates'					=>	'PunBB 更新：',
'Updates failed'			=>	'最近一次从 punbb.informer.com 检查更新失败。这可能是因为服务暂时过载或故障。如果此通知在一两天后仍未消失，建议您禁用自动更新检查，改为手动检查。',
'Updates version n hf'		=>	'新版本 PunBB %s 已可从 <a href="https://punbb.informer.com/">punbb.informer.com</a> 下载。此外，管理界面的<a href="%s">管理热修复</a>标签页中有一个或多个热修复可供安装。',
'Updates version'			=>	'新版本 PunBB %s 已可从 <a href="https://punbb.informer.com/">punbb.informer.com</a> 下载。',
'Updates hf'				=>	'管理界面的<a href="%s">管理热修复</a>标签页中有一个或多个热修复可供安装。',
'Database mismatch'			=>	'数据库版本不匹配',
'Database mismatch alert'	=>	'您的 PunBB 数据库需要与更新版本的 PunBB 代码配合使用。此不匹配可能导致论坛无法正常运行。建议您将论坛升级到最新版本的 PunBB。',

// Stuff for Jump Menu
'Go'						=>	'前往',		// submit button in forum jump
'Jump to'					=>	'跳转到版块：',

// For extern.php RSS feed
'RSS description'			=>	'%s 的最新主题。',
'RSS description topic'		=>	'%s 的最新帖子。',
'RSS reply'					=>	'Re: ',	// The topic subject will be appended to this string (to signify a reply)

// Accessibility
'Skip to content'			=>	'跳转到论坛内容',

// Debug information
'Querytime'					=>	'页面生成耗时 %1$s 秒（PHP %2$s%% - 数据库 %3$s%%），共 %4$s 次查询',
'Debug table'				=>	'调试信息',
'Debug summary'				=>	'数据库查询性能信息',
'Query times'				=>	'耗时（秒）',
'Query'						=>	'查询',
'Total query time'			=>	'总查询时间',

// Error message
'Forum error header'		=> '抱歉！页面无法加载。',
'Forum error description'	=> '这可能是临时错误。请刷新页面重试。如果问题持续存在，请在 5-10 分钟后重试。',
'Forum error location'		=> '错误发生在 %2$s 的第 %1$s 行',
'Forum error db reported'	=> '数据库报告：',
'Forum error db query'		=> '失败的查询：',

// Menu
'Menu admin'		=> '管理菜单',
'Menu profile'		=> '个人资料菜单',

);
