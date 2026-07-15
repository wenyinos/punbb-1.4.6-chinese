# PunBB 1.4.6 中文汉化版

基于 [PunBB](https://punbb.informer.com/) 1.4.6 的简体中文汉化版本，已移植至 PHP 8.4+。

## 特性

- 完整简体中文语言包（`lang/Chinese/`）
- 双主题支持：Oxygen（经典）+ Pixel（Bootstrap 5 现代风格）
- PHP 8.4+ 兼容（已移除已弃用函数、修复类型安全）
- bcrypt 密码哈希（自动升级旧 SHA1/MD5 哈希）
- 增强的安全防护（CSRF、XSS、SQL 注入、会话固定、Host 头注入等）
- 支持 MySQLi 5.6+ / PostgreSQL 9.1+ / SQLite 3

## 快速安装

1. 下载并解压到 Web 服务器目录
2. 访问 `http://你的域名/admin/install.php`，按向导操作
3. 安装完成后建议删除或重命名 `admin/install.php` 和 `admin/db_update.php`

## 环境要求

- Web 服务器（Apache / Nginx）
- PHP 8.4 或更高版本
- MySQL 5.6+（MySQLi）/ PostgreSQL 9.1+ / SQLite 3

## 目录结构

```
├── admin/            后台管理页面
├── db/               SQLite 数据库存储（受 .htaccess 保护）
├── extensions/       插件目录
├── include/          核心逻辑（函数、数据库抽象、模板引擎、解析器）
├── lang/             语言包（English/、Chinese/）
├── style/            主题样式
│   ├── Oxygen/       经典主题
│   └── Pixel/        Bootstrap 5 现代主题（离线运行，含 FontAwesome 6）
├── cache/            模板缓存
└── img/              图片及头像
```

## 主题

### Oxygen（经典主题）
PunBB 原版主题，轻量简洁。

### Pixel（Bootstrap 5 现代主题）
基于 [Pixel Bootstrap UI Kit](https://github.com/Themesberg/pixel-bootstrap-ui-kit) 设计，采用 Bootstrap 5 + FontAwesome 6，全离线运行，无外部 CDN 依赖。

切换方式：管理后台 → 设置 → 默认样式 → 选择 `Pixel`。

## 安全审计

项目已通过全面安全审计，详见 [SECURITY_AUDIT_REPORT.md](SECURITY_AUDIT_REPORT.md)。

已修复的主要安全问题：
- 数据库升级脚本缺少身份验证（现需管理员登录）
- SQLite 数据库文件 Web 访问保护
- 存储型 XSS（公告、规则、维护消息、论坛描述）
- Host Header 注入防护
- 开放重定向修复
- Cookie SameSite/HttpOnly 属性
- 会话固定防护（移除 GET 参数 Session ID）
- 密码哈希迁移至 bcrypt
- 密码重置密钥增强至128位熵
- 时序安全的密码比较（hash_equals）
- bcrypt 登录 Cookie 哈希传递修复

## 扩展安装

1. 下载插件包，解压到 `extensions/` 目录
2. 登录管理后台 → 扩展 → 安装扩展
3. 点击对应扩展的"安装"链接

## 许可证

本项目基于 [GNU General Public License v2](http://www.gnu.org/licenses/gpl.html) 许可证发布。

原 PunBB &copy; 2002-2012 PunBB，部分代码基于 FluxBB.org &copy; 2008-2009。
中文汉化及 PHP 8.4+ 移植 &copy; 2026 [wenyinos](https://github.com/wenyinos/punbb-1.4.6-chinese)。

## 链接

- [原版 PunBB 官网](https://punbb.informer.com/)
- [本项目 GitHub](https://github.com/wenyinos/punbb-1.4.6-chinese)
- [PunBB 扩展仓库](https://punbb.informer.com/extensions/)
- [PunBB 社区论坛](https://punbb.informer.com/forums/)
