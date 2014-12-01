tLang
=====

Simple PHP language management class.
Developed by @tankotun (Taner Tuncer)

## Nedir?
Projelerinize çoklu dil desteği ekleyebilmenizi sağlayan açık kaynak PHP sınıfıdır.
Dil dosyaları php uzantılı dosyalarda dizilerde (array) saklanır.
Dil dosyalarında kendine has bir düzeni vardır.

## Temel Ayarlar
Temel ayarlarda dil dosyalarının bulunduğu dizini, kullanılacak dili ve varsayılan dili belirtmemiz gerekir.
```php
# Sınıf dosyasını dahil ediyoruz.
require "tLang/tLang.class.php";

# tLang sınıfını oluşturuyoruz
# Ilk olarak  sınıfa, dil dosyalarının olduğu dizinin yolunu belirtiyoruz.
new tLang('langFiles');

# Set methodu ile kullanılacak dili (seçilen dil) 'tr' olarak ayarlıyoruz.
tLang::set('lang', 'tr');

# Varsayılan dil olarak ise 'en' ayarlıyoruz.
# Dil dosyasında istenilen bloğun seçilen dile desteği olmaması halinde,
# içerik varsayılan dil ile gösterilir.
tLang::set('defaultLang', 'en');
```
Temel ayarlar bu kadar.

## Dil Dosyaları Düzeni
Dil dosyaları tLang sınıfına belirttiğimiz dizinin içinde saklanır. Dil dosyalarında düzen; bölgeler (zone) ve bloklar (block) veya sadece blok olaraktır.

örn: (genel.php dil dosyası)
```php
return array(

	### 'header' burada bir bölgedir.
	'header' => array(
    
		### 'slogan' burada bir bloktur.
		### 'slogan' içindeki 'tr' ve 'en' ise desteklenen dillerin içerikleridir.
		'slogan'  => array(
			'tr'  => 'En iyi blog!',
			'en'  => 'The best blog!'
		)
    
	),
	
	### 'mesaj' burada direkt olarak bir blok olarak tanımlanmıştır
	'mesaj'	=> array(
		'tr'	=> 'Hosgeldiniz!',
		'en'	=> 'Welcome!'
	)
  
);
```
Bölgelerin içinde birden fazla blok bulunabilir. *<br/>
Bütün dil içeriğini tek bir dosyada saklamanız gerekmez. Dil dizini içerisinde istediğiniz kadar dil dosyası oluşturabilirsiniz.<br/>tLang dizindeki bütün dil dosyalarını yükler, içeriğini birleştirir ve okur.
Burada dikkat etmeniz gereken, farklı dil dosyalarında dahi aynı bölge veya direkt yazılmış blok isimleri kullanmamaktır.

## Bloklara ulaşma, Içerik Görüntüleme
```php
# 'header' bölgesindeki 'slogan' bloğunun içerğini aldık. Dönen içerik 'tr' formatındadır.
tLang::get('header.slogan');
# Çıktı: En iyi blog!

# 'mesaj' bloğunu alalım.
tLang::get('mesaj');
# Çıktı: Hoşgeldiniz!
```

## Bloklarda Dizi Oluşturma
Bloklar içerisine mesela menü nesneleri ekleyebilir ve bunları get edebilirsiniz.
<br/>örn: (genel.php dil dosyası)
```php
return array(
	
	# bir blok
	'test' => array(
		'tr' => array(
			'Anasayfa',
			'Hakkımızda'
		),
		
		'en' => array(
			'Home',
			'About'
		)
	),
	
	# baska bir blok
	'ikinciTest'	=> array(
		'tr' => array(
			'ilkMadde'	=> 'Merhaba'
		),
		
		'en' => array(
			'ilkMadde'	=> 'Hello'
		)
	)
	
);
```

Ulaşmak için:
```php
tLang::get('test:1');
# Çıktı: Anasayfa
```
<br/> Dizi elemanlarını ismlendirererk de get edebilirsiniz:
```php
tLang::get('ikinciTest:ilkMadde');
# Çıktı: Merhaba
```

## Blok içinde değişken tanımlama

örn: (genel.php dil dosyası)
```php
return array(
	
	'test' => array(
		'tr'	=> 'Hosgeldiniz, --username--! IP Adresiniz --ip--',
		'en'	=> 'Welcome, --username--! Your IP Address is --ip--'
	),
	
);
```
4 tire içine yazılan değer değişken olarak alınır.
<br/><br/>Kullanımı:
```php
# get() methodunda ikinci parametre değişkenler dizisidir.
$args = array('username' => 'tankotun', 'ip' => '0.0.0');
tLang::get('test', $args);
# Çıktı: Hoşgeldiniz, tankotun! IP Adresiniz 0.0.0
```
Sınırsız değişken tanımlayabilirsiniz. *

## Filtreler
Dil dosyalarından get ettiğiniz içeriği, desteklenen fonksiyonlarla filtreleyebilirsiniz.
<br/>Desteklenen fonksiyonlar: htmlspecialchars (html taglarını temizleme), stripslashes (ters slash silme)
<br/>get() methodunda 3.parametre filtredir
<br/>Kullanımı:
```php
# Değişkenler parametresini 'null' yaparak geçebilirsiniz.
# Fonksiyonlar virgülle ayırılarak yazılır. 
tLang::get('header.slogan', null, 'htmlspecialchars, stripslashes');
```

<br/><br/><br/>Afiyet olsun.<br/>
God bless open source programmers.
