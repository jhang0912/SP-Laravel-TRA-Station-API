<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About 「Laravel TRA Station API Server」

這是一份使用 PHP 框架 Laravel 進行撰寫的作品，以「公共運輸整合資訊流通服務平臺 」所提供的台鐵車站資料為基礎，加以串接整理後開發(搭配 Redis 儲存資料)供第三方使用者可應用的 API Server，請參考以下使用說明：

## 快速入門

|方法|網址|功能說明|
|--|--|--|
|GET|http://35.194.145.6/v1/tra/stations|取得所有台鐵車站的基本資料|
|GET|http://35.194.145.6/v1/tra/stations/{車站名稱}|取得單一台鐵車站的基本資料|
|GET|http://35.194.145.6/v1/tra/stations/{車站名稱}/exits|取得單一台鐵車站所有出入口資料|

## 資料篩選
### 使用「取得所有台鐵車站的基本資料」服務時，可選擇附帶參數(二擇一)篩選資料，說明如下：
- address：不限位數中文字串(string)，例如：台北市、中正區、新北、板橋
- post code：三位數整數(integer)郵遞區號，例如：100、220
### 串接範例
- address：http://35.194.145.6/v1/tra/stations?address=板橋區
- post code：http://35.194.145.6/v1/tra/stations?postCode=220

## 使用說明
### 使用「取得單一台鐵車站的基本資料」服務時，{ }內需填入英文字串，內容為車站名稱，例如：Taipei、Wanhua
### 串接範例
- http://35.194.145.6//v1/tra/stations/Taipei

## 嵌套資料
### 使用「取得單一台鐵車站的基本資料」服務時，可於網址後方輸入 「/exits 」查詢車站所有出入口資料

## 注意事項
- 速率限制：每分鐘接受最多60次請求

## 部署環境
|工具|版本|
|--|--|
|雲端服務|GCP|
|OS|Ubuntu 20.04 LTS|
|Apache|2.4.41|
|PHP|8.0|
|Laravel|8.62|
|Redis|5.0.7|

