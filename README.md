# sampleリポジトリ

| バージョン | 日にち     |
| ---------- | ---------- |
| 1.00       | 2023/12/22 |

## 目次

- [sampleリポジトリ](#sampleリポジトリ)
  - [目次](#目次)
  - [作業内容](#作業内容)
    - [ディレクトリ構造の設計](#ディレクトリ構造の設計)
    - [Apacheの設定変更](#apacheの設定変更)
  - [更新履歴](#更新履歴)

## 作業内容

### ディレクトリ構造の設計

### Apacheの設定変更

<span style='color :red'>
apache\conf\httpd.conf
</span>
を編集。

``
<IfModule dir_module>
    DirectoryIndex index.php index.pl index.cgi index.asp index.shtml index.html index.htm \
                   default.php default.pl default.cgi default.asp default.shtml default.html default.htm \
                   home.php home.pl home.cgi home.asp home.shtml home.html home.htm \
                   repo_sample/index.php
</IfModule>
``

## 更新履歴

| バージョン | 日にち     | 更新内容                                          |
| ---------- | ---------- | ------------------------------------------------- |
| 1.00       | 2023/12/22 | [ディレクトリ構造の設計](#ディレクトリ構造の設計) |
