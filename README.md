# symfony-5-orders-api
Symfony 5 Orders Api

### Gereksinimler
- PHP 8.0 ve üstü
- Symfony 5.4 ve üstü
- Mysql

### Kurulum
- .env dosyasına kopyalayarak gerekli veritabanı parametre ayarlamalarını yapıyoruz.
- jwt için extra key generator yapmaya gerek yoktur env dosyasındaki keylerle devam edebiliriz
```
php composer update
```
- komutu ile composer.json'da ki gerekli paket kurulumlarını yapıyoruz
```
php bin/console doctrine:migrations:migrate
```
- komutunu çalıştırarak gerekli migrationları ayağa kaldırıyoruz

```
symfony server:start
```
- Github ile projemizi başlatıyoruz.
- Proje dosyalarının içerisinde bulunan Orders Api.postman_collection.json dosyasını postman'dan içe aktarım yaparak koleksiyonlarımıza ulaşıyoruz
- Postman koleksiyonunda variables bölümünden API_URL'yi düzenliyoruz.
- user -> register methodundan register olup user->login menüsünden tokenimizi aldıktan sonra potman koleksiyonumuzun varianles kısmına dönüp token kısmına yapıştırıyoruz.
- Token geçerlilik süresi 60 dakika olarak ayarlanmıştır




### Kullanılan kütüphaneler
- symfony/orm-pack -> veritabanı bağlantısı paketi
- symfony/maker-bundle -> komut satırından dosyaları oluşturma paketi
- lexik/jwt-authentication-bundle -> jwt token paketi
- jms/serializer-bundle -> json serialize paketi
- friendsofsymfony/rest-bundle -> api hatalarını seri hale getirme paketi
