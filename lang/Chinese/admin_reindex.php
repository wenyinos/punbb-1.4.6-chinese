<?php

// Language definitions used in all admin files
$lang_admin_reindex = array(

'Reindex heading'			=>	'重建搜索索引以恢复搜索性能',
'Rebuild index legend'		=>	'重建搜索索引',
'Reindex info'				=>	'如果您在数据库中手动添加、编辑或删除了帖子，或者搜索出现问题，应重建搜索索引。为获得最佳性能，重建期间应将论坛置于维护模式。完成后页面将自动跳转回此页面。强烈建议在重建期间启用浏览器的 JavaScript（用于循环完成后自动跳转）。',
'Reindex warning'			=>	'<strong>重要！</strong>重建搜索索引可能需要很长时间，并会增加重建过程中的服务器负载。如果您被迫中止重建过程，请记录最后处理的帖子 ID，并在继续时在"起始帖子 ID"中输入该 ID+1。',
'Empty index warning'		=>	'<strong>警告！</strong>如果您要恢复中止的重建，请不要选择"清空索引"。',
'Posts per cycle'			=>	'每循环帖子数',
'Posts per cycle info'		=>	'每次页面加载处理的帖子数量。例如，如果您输入 100，将处理一百个帖子，然后页面会刷新。这是为了防止脚本在重建过程中超时。',
'Starting post'				=>	'起始帖子 ID',
'Starting post info'		=>	'开始重建的帖子 ID。默认值是数据库中第一个可用 ID。通常您不需要更改此项。',
'Empty index'				=>	'重建前清空搜索索引（见下文）。',
'Rebuilding index title'	=>	'正在重建搜索索引…',
'Rebuilding index'			=>	'正在重建索引… 现在可能是喝杯咖啡的好时机 :-)',
'Processing post'			=>	'正在处理主题 <strong>%2$s</strong> 中的帖子 <strong>%1$s</strong>。',
'Javascript redirect'		=>	'JavaScript 跳转未成功。',
'Click to continue'			=>	'点击这里继续',
'Rebuild index'				=>	'重建索引',

);
