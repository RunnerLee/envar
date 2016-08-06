# Envar

加载配置到环境变量中

### 安装
```
composer require runner/envar
```

### 使用

配置文件以 `{key}={value}` 的键值对形式配置，一行一个配置。 键名约束等同于PHP的变量命名约束，且长度不超过100。

所以，在配置文件中，值可以使用标量类型及空类型。

例如 `APP_DEBUG=true` 配置, 在读取时会返回一个 `(boolean) true`

所以，如果想使用字符串的 `false` / `true` / `null` 的话，可以使用引号将值包起来。例如：`APP_DEBUG="true"`

```
$envar = new Envar(['LANG']); // 读取系统环境变量配置

$envar->load(__DIR__ . '/.env'); // 读取会话环境变量配置, 会覆盖重复的变量

$envar->get('LANG'); // gbk
```

### Testing

```
phpunit
```
