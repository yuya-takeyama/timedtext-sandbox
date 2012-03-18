TimedText sandbox
=================

[TimedText](https://github.com/yuya-takeyama/timedtext) の動作を確認するためのサンドボックスです.  
マイクロフレームワーク Silex により構築されています.

動作要件
--------

- PHP 5.3.2 以降
- Apache
- .htaccess により mod\_rewrite の設定が変更できる

インストール
------------

インストールには Git が必要です.

```
$ git://github.com/yuya-takeyama/timedtext-sandbox.git
$ cd timedtext-sandbox
$ ./install-vendor.sh
```

./public ディレクトリを DocumentRoot に設定してください.

作者
----

Yuya Takeyama [http://yuyat.jp/](http://yuyat.jp/)
