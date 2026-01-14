# Project Manager


## 概要

Laravel + Breeze を用いた認証機能付きWebアプリケーションの基盤構築。
Windows / macOS の両環境で同一リポジトリを利用できるよう、
環境差異を考慮した開発環境構築を行っています。


## 技術スタック

### Backend
- PHP 8.x
- Laravel 10
- Laravel Breeze（認証）

### Frontend
- Blade
- Tailwind CSS
- Vite

### Database
- MySQL

### 開発ツール
- Git / GitHub
- Visual Studio Code


## 開発環境

| OS | 構成 |
|----|----|
| Windows | XAMPP（Apache / PHP / MySQL） |
| macOS | Homebrew + PHP + Composer + Node.js |

- Windows 環境では XAMPP を使用し、GUI によるサーバ管理を行っています
- macOS 環境では Homebrew を利用し、CLI ベースで環境構築を行っています
- GitHub を介して、両環境から同一プロジェクトを操作可能です

## 環境構築手順 ★

### 前提条件
以下がインストールされていることを前提とします。
- PHP 8.x
- Composer
- Node.js / npm
- Git

### リポジトリをクローン

```bash
git clone git@github.com:Tenkey25/project-manager.git
cd project-manager
### リポジトリをクローン

```bash
git clone git@github.com:Tenkey25/project-manager.git
cd project-manager


```md
### フロントエンド依存関係のインストール

```bash
npm install

---

## 環境変数設定（ここ超重要）

```md

### 環境設定ファイルの作成

```bash
cp .env.example .env


---

## アプリケーションキー生成

```md
### アプリケーションキー生成

```bash
php artisan key:generate


👉 **ここで「APP_KEY がないと 500 エラーになる」経験が活きている**

---

## 開発サーバ起動（2つ必要）

```md
### 開発サーバ起動（Laravel）

```bash
php artisan serve

### フロントエンドビルド（Vite）

```bash
npm run dev


## よくあるトラブル

### 500 Server Error が出る場合
- `.env` が存在しない
- `APP_KEY` が未生成

→ `php artisan key:generate` を実行する

### Vite manifest not found エラー
- `npm run dev` が起動していない

→ フロントエンド開発サーバを起動する

### SSH Permission denied
- GitHub に SSH 公開鍵が登録されていない

→ `ssh -T git@github.com` で接続確認




## 補足
本プロジェクトは Laravel 10 をベースに構築しています。
Laravel の詳細については公式ドキュメントを参照してください。
https://laravel.com/docs