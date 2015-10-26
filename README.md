# AFA-PHP Framework
AFA is a simple php framework, it is very fast, very small, and useful.<br />

支持功能<br />
1. MVC模式<br />
2. MYSQL PDO, 支持一主多从主(读写分离)，支持按模块配置不同数据库，并且每个模块都可以进行一主多从<br />
3. SQL build：SQL生成，可有效防止SQL注入<br />
4. Modules：按模块进行项目开发，适合团队协作开发<br />
5. Codemaker：自动生成模块代码，包括增,删,改,查(列表，单条记录展示)<br />
6. 使用jquery,bootstrap<br />
7. 代码自动加载<br />
8. 支持不同模块间相互调用，支持自动与收到加载其他模块文件<br />
9. 可内部 Request::instance('/hello/index')->run(); 自由调用，方便Controller自由交互
