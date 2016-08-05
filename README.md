# Envar

加载配置到环境变量中

### 安装
```
composer require runner/envar
```

### 使用

配置文件以 `{key}={value}` 的键值对形式配置，一行一个配置。 键名约束等同于PHP的变量命名约束，且长度不超过100。

在通过 `envar()` 函数读取env配置时，将会对值判断数据类型并尝试转换。

所以，在配置文件中，值可以使用标量类型及空类型。

例如 `APP_DEBUG=true` 在使用 `envar('APP_DEBUG')` 时会返回一个 `(boolean)true`

所以，如果想使用字符串的 `false` / `true` / `null` 的话，可以使用引号将值包起来。例如：`APP_DEBUG="true"`