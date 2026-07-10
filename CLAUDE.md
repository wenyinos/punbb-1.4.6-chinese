# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 项目概述

PunBB 1.4.6 中文汉化版 — 基于 PHP 的轻量论坛程序。原始代码 (C) 2002-2012 PunBB，GPL v2 许可证。

## 技术栈

- PHP 5+（纯过程式，无框架）
- 数据库：MySQL 4.1.2+ / PostgreSQL 7.0+ / SQLite 2
- 模板引擎：自研 `include/template/` 下的 `.tpl` 文件
- 前端样式：`style/Oxygen/`（含 CSS 和图片）
- 语言包：`lang/English/`（中文汉化在此目录内）

## 架构说明

### 请求处理流程

每个顶级 `.php` 文件都是一个独立页面入口（如 `index.php`、`viewforum.php`、`post.php`），它们共享相同的初始化链：

```
include/common.php
  └→ include/essentials.php（加载配置、定义常量、初始化 DB 连接）
     └→ include/functions.php（全局函数库，含用户认证、权限、输出等）
```

页面顶部调用 `require 'include/common.php'`，之后用 `include/template/main.tpl` 渲染输出。

### 关键目录

- `include/` — 核心逻辑：`common.php`、`functions.php`、`parser.php`（BBCode 解析）、`email.php`
- `include/dblayer/` — 数据库抽象层，支持 MySQL/MySQLi/PostgreSQL/SQLite，统一接口在 `common_db.php`
- `include/template/` — 模板引擎：`main.tpl`（主布局）、`admin.tpl`（后台）、`redirect.tpl`、`help.tpl`
- `admin/` — 后台管理页面（settings、users、forums、groups 等），共用 `common_admin.php`
- `extensions/` — 插件目录，通过后台 Extensions 页面安装/启用
- `lang/English/` — 语言文件，按页面命名（如 `index.php`、`viewtopic.php`）
- `style/Oxygen/` — 主题样式文件和 CSS

### 数据库抽象

`include/dblayer/` 为每种数据库提供同名类文件，所有类继承自 `common_db.php` 中定义的基类。代码中通过 `$forum_db` 全局对象操作数据库，方法包括 `query()`、`fetch()`、`result()` 等。

### 模板系统

- `.tpl` 文件使用 `<pun_include>`、`<pun_url>` 等自定义标签
- PHP 端通过 `define()` 和字符串替换完成模板变量注入
- 模板编译结果缓存到 `cache/` 目录

### 扩展机制

扩展放置在 `extensions/<ext_name>/` 下，需包含 `manifest.xml` 描述元数据。通过 `$forum_loader` 对象注册钩子和加载扩展代码。

## 常用操作

### 安装/初始化
```bash
# Web 安装：访问 http://yourdomain/admin/install.php
# 数据库升级：访问 http://yourdomain/admin/db_update.php
```

### 开发调试
- 开启调试：在 `config.php` 中设置 `$forum_config['o_show_queries'] = '1'` 显示 SQL 查询
- 模板缓存：修改 `.tpl` 文件后需清除 `cache/` 下对应缓存文件才能生效
- 语言包缓存：修改 `lang/` 下文件后同样需清除缓存

### 文件修改后生效
```
清除 cache/ 目录下文件 → 刷新浏览器
```

## 注意事项

- 代码为纯过程式 PHP，无 OOP（数据库层除外），所有状态通过全局变量传递：`$forum_user`、`$forum_config`、`$forum_db`、`$forum_page`
- `parser.php` 处理 BBCode 和用户输入，修改时务必注意 XSS 安全
- `functions.php` 是最大的文件（~1500+ 行），包含所有核心函数
- 用户权限通过 `forum_user` 数组中的 `g_*` 字段控制，修改权限逻辑需同时更新 `admin/groups.php`
