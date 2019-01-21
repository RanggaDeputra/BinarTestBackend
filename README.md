# BinarTestBackend

Jawaban pertanyaan test Backend Binar
Hasil No. 1 dan No. 2 terdapat pada file BinarTest Backhend.docx.
Hasil No. 3 terdapat pada file binar_api.zip, database yang digunakan ada pada file binarbe.sql, 
capture pada file PostmanTestCapture.docx.
Hasil No. 4 terdapat pada file BinarTest Backhend.txt.

Installing
Installing XAMPP (https://www.apachefriends.org/faq_windows.html)

Restore Database
1. Open PHPMyAdmin
2. Create new database dengan nama binarbe
3. Pilih tab Import
4. Pilih tombol Choose File 
5. Pilih file database dengan format .sql
6. Pilih tombol GO

Ekstrak file api .zip

Create Inisialisasi data product dan productdetail
dapat menggunakan query

INSERT INTO `product`(`ID`, `ProdukNo`, `Deskripsi`, `Harga`, `Stock`, `StatusProduk`, `CreatedTime`, `CreatedBy`, `LastModifiedTime`, `LastModifiedBy`, `RowStatus`) VALUES (1,'1111111','fffffff',5000,4,'tersedia','1970-01-01','aye','1970-01-01','aye',0)

INSERT INTO `productdetail`(`ID`, `ProductID`, `NamaGambar`, `URLGambar`, `CreatedTime`, `CreatedBy`, `LastModifiedTime`, `LastModifiedBy`, `RowStatus`) VALUES (1,1,'52231_0.jpg','52231_0.jpg','1970-01-01','aye','1970-01-01','aye',0)

Running the tests

Test RESTful API dilakukan dengan melakukan hits ke server dan mengecek reponse kiriman datanya.

Tools 

    PHP - Language
    XAMPP - Web Server
    MySQL - Database
    Postman - Cek API
    Notepad++ - Making file API
