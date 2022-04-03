<?php class_exists('Template') or exit; ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PandoraDocs - Mint</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo htmlentities(asset('css/scribbler-global.css'), ENT_QUOTES, 'UTF-8') ?>">
<link rel="stylesheet" href="<?php echo htmlentities(asset('css/scribbler-landing.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?php echo htmlentities(asset('css/scribbler-doc.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?php echo htmlentities(asset('css/prism.css'), ENT_QUOTES, 'UTF-8') ?>">
  <!-- tree -->
  <link href="<?php echo htmlentities(asset('tree/css/file-explore.css'), ENT_QUOTES, 'UTF-8') ?>" rel="stylesheet">

  <!-- Font awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<style>
  .directory{
    background-color: #dfe6e9;
    padding: 5px;
    color: #3d3d3d;
    width: 100%;
    margin-bottom: -10px !important;
  }

  .quote{
    background-color: #ffeaa7;
    padding: 5px;
    color: #3d3d3d;
  }

</style>

<body>

<div class="doc__bg"></div>
  <nav class="header">
    <h1 class="logo">Pandoracode<span class="logo__thin">Mint</span></h1>
    <ul class="menu">
      <div class="menu__item toggle"><span></span></div>
      <li class="menu__item"><a href="" class="link link--dark"><i class="fa fa-graduation-cap"></i> Kursus</a></li>
      <li class="menu__item"><a href="index.html" class="link link--dark"><i class="fa fa-globe"></i> Forum</a></li>
    </ul>
  </nav>

 
  <div class="wrapper">
    <aside class="doc__nav">
      <ul>

        <span style="font-size:13px;color:#ced6e0">Pengenalan</span>
        <li class="js-btn selected">Instalasi</li>
        <li class="js-btn">Routing System</li>
        <li class="js-btn">View & Templating</li>
        <li class="js-btn">Controller</li>
        <hr style="margin-top:-23px">
        <span style="font-size:13px;color:#ced6e0">CRUD</span>
        <li class="js-btn">Create</li>
        <li class="js-btn">Read</li>
        <li class="js-btn">Edit & Update</li>
        <li class="js-btn">Delete</li>

      </ul>
    </aside>
    <article class="doc__content"><br>
      <section class="js-section">

        <div class="alert-warning">

            <h1 class="title-section-sidebar">Pengenalan</h1>
            <p>Pandoracode Mint adalah sebuah <b>Framework PHP Mini</b> yang dibangun untuk kerja solo maupun tim, <br> kami memanfaatkan beberapa <code>library</code> yang sudah ada, terlebih Anda bisa menambahkan<code>library</code> baru sesuai dengan keinginan Anda.</p>

        </div>

        <h3 class="section__title">Instalasi</h3>

        <p><span style="color:red">*</span>Pastikan laptop/PC Anda sudah terinstall composer, jika belum bisa download <a target="_blank" href="https://getcomposer.org/download/">disini</a>.</p>

        <p>Buka Command Prompt kemudian ketikan perintah berikut : </p>

        <pre><code class="language-html">composer create-project pandoradev/pandoracode-mint nama-project</code></pre>

        <p>Jika proses sudah selesai, kemudian pindah ke direktory project Anda.</p>

        <pre><code class="language-html">cd nama-project</code></pre>

        <p>Jika anda ingin menjalankan Pandoracode Mint secara langsung, Anda dapat menuliskan command berikut :</p>

        <pre><code class="language-html">php pcode run</code></pre>

        <p>Kemudian ketik di URL Anda : <b>localhost:8080</b></p>

      </section>
      <section class="js-section">
        <h3 class="section__title">Routing System</h3>
        <p>
          Mendefinisikan rute untuk antarmuka web Anda, ringan, dan sangat cepat untuk proyek PHP. <br>
          Kami menggunakan <code>library : miladrahimi/phprouter</code>.<br><br>
          Contoh penggunaan di file <code>routes/web.php</code> :
        </p>

        <pre><code class="language-php">$router->get('/', function () {
    echo 'This is Pandoracode Mint!';
});</code></pre>
        <h4>Route Controller</h4>

        <p>Jika ingin terintegrasi dengan controller Anda bisa membuat code seperti contoh di bawah ini.</p>

        <pre><code class="language-php">$router->get('url', [<b class="controller-name">NamaController</b>::class, 'nama_method']);</code></pre>

        <h4>Route Paramter</h4>
        <p>Mungkin Anda perlu mengambil ID dari URL. Anda dapat melakukannya dengan menentukan parameter rute</p>

      <pre><code class="language-php">$router->get('/post/{id}', function ($id) {
    echo "id nya adalah $id";
});</code></pre>
        
        <hr />
      </section>
      <section class="js-section" id="view">
        <h3 class="section__title">View & Templating</h3>
        <p>Bagaimana cara membuat sebuah tampilan/view baru pada Pandoracode Mint? <br>
        Sebelum ke pembuatan view, Pandoracode Mint menempatkan lokasi tampilan/view di direktori <code>resources/views</code>. <br>
        Ada dua versi cara pembuatan view (manual dan CLI).</p>

        <h4>Pembuatan View</h4>

        <p>Untuk versi CLI kami menyediakan dua bentuk command, yang mana dari tiap perintah mempunyai fungsi yang berbeda, <br>
          seperti ini contoh nya :</p>

        <h4>Satu file view</h4>

        <pre><code class="language-html">php pcode make:view nama_view</code></pre>

        Akan otomatis membuat sebuah file baru (.php) di dalam <code>resources/views</code> sesuai dengan nama view Anda. <br>

        <ul class="file-tree">
            <li class="folder-root open"><a style="margin-left: 7px;"> views</a>
                <ul>
                    <li><a>nama_view.php</a> </li>
                </ul>
            </li>
        </ul>

        <h4>View dalam folder</h4>

        <pre><code class="language-html">php pcode make:view nama-folder/nama_view</code></pre>

        <p>Akan otomatis membuat sebuah file baru (.php) di dalam <code>resources/views</code> sesuai dengan nama folder dan view Anda.</p>

        <ul class="file-tree">
            <li class="folder-root open"><a style="margin-left: 7px;"> views</a>
                <ul>
                    <li class="folder-root open">
                        <a style="margin-left: 7px;"> nama-folder</a>
                        <ul>
                            <li><a>nama_view.php</a> </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>

        <br>

        <h4>Trinity file view</h4>

        <pre><code class="language-html">php pcode make:view nama-folder --full</code></pre>

        <p>Akan otomatis membuat sebuah folder baru di dalam <code>resources/views</code> sesuai dengan nama folder Anda, dan juga membuat 3 file di dalamnya </p>

        <ul class="file-tree">
            <li class="folder-root open"><a style="margin-left: 7px;"> views</a>
                <ul>
                    <li class="folder-root open">
                        <a style="margin-left: 7px;"> nama-folder</a>
                        <ul>
                            <li><a>data.php</a> </li>
                            <li><a>form-edit.php</a> </li>
                            <li><a>form.php</a> </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul><br>

        <h4>Templating view</h4>

        <p>Apa itu templating view dan bagaimana cara penggunaan nya? <br> Sebelum lanjut, kita perlu memahami arti kata template dalam bidang ilmu komputer ialah : </p>

        <p><i class="quote">"Sebuah dokumen atau file yang memiliki format preset, digunakan sebagai titik awal untuk aplikasi tertentu sehingga format tidak harus diciptakan kembali setiap kali digunakan"</i></p>

        <p>Jadi pengertian yang sangat umum dari desain template adalah pola layout dari sebuah website yang ingin didesain dan disiapkan dengan berbagai fitur, content suatu bidang di dalamnya. Kita juga bisa merubah serta mengedit serta mengembangkan kembali dari desain yang di rencanakan.</p>
        
        <h4>Membuat templating</h4>
        <p>Pun ada dua cara pembuatan templating, manual dan CLI. </p>

        <pre><code class="language-php">php pcode make:layout template</code></pre>

        <p>Akan otomatis membuat sebuah file baru (.php) di dalam <code>resources/layouts</code> sesuai dengan nama template Anda.</p>

        <ul class="file-tree">
            <li class="folder-root open"><a style="margin-left: 7px;"> layouts</a>
                <ul>
                    <li><a>template.php</a> </li>
                </ul>
            </li>
        </ul><br>

        <p>Kemudian untuk template engine nya seperti ini.</p>

        <pre><code class="language-html"><?php echo htmlspecialchars(file_get_contents('resources/views/component/template.php')) ?></code></pre>

        <p>Sekarang kita mencoba menggunakan template yang sudah kita buat, misalnya kita punya file di direktori <code>resources/views</code> dengan nama <br>test.php, buat isi file tersebut menjadi seperti ini :</p>

        <pre><code class="language-html"><?php echo htmlspecialchars(file_get_contents('resources/views/component/test.php')) ?></code></pre>
        
        <p>Kemudian silahkan Anda coba untuk menjalakan project anda di browser.</p>

        <hr />

      </section>
      <section class="js-section" id="controller">
        
        <h3 class="section__title">Controller</h3>
        <p>Controller merupakan program yang mengatur, menerima input dan menjalankan beberapa perintah untuk dijalankan. <br>Bisa juga mengambil hasil olahan dan menatanya di bagian view.</p>

        <h4>Pembuatan Controller</h4>
        <p>Sebelum ke pembuatan controller, Pandoracode Mint menempatkan lokasi controller di direktori <code>controllers</code>. <br>Berikut beberapa cara pembuatan controller :</p>

        <h4>Standart</h4>

        <pre><code class="language-php">php pcode make:controller Test</code></pre>

        <p>Akan otomatis membuat sebuah file baru (.php) di dalam <code>controllers</code> sesuai dengan nama controller Anda. </p>

        <ul class="file-tree">
            <li class="folder-root open"><a style="margin-left: 7px;"> controllers</a>
                <ul>
                    <li><a>Test.php</a> </li>
                </ul>
            </li>
        </ul>
        <div class="directory"> <i class="fa fa-folder"></i> controllers/Test.php</div>
        <pre><code class="language-php">&#60;?php

  namespace Controllers;

  use QB;
  use Rakit\Validation\Validator;
  use Laminas\Diactoros\ServerRequest AS Request;

  class Test
  {

      public function index()
      {
          echo 'This is index';
      }

  }</code></pre>

        <h4>Auto setup router & method</h4>

        <pre><code class="language-html">php pcode make:controller Test --full</code></pre>

        <p>Akan otomatis membuat sebuah file baru (.php) di dalam <code>controllers</code> sesuai dengan nama controller Anda dan juga setup <br> <code>routes/web.php</code> untuk semua request beserta menyiapkan method-method di controller Anda </p>
        <div class="directory"> <i class="fa fa-folder"></i> controllers/Test.php</div>
        <pre><code class="language-php">&#60;?php
        
  namespace Controllers;

  use QB;
  use Rakit\Validation\Validator;
  use Laminas\Diactoros\ServerRequest AS Request;

  class Test
  {

      public function index()
      {
          echo 'This is index';
      }

      public function create()
      {
          //code
      }

      public function store(Request $request)
      {
          //code
      }

      public function edit($id)
      {
          //code
      }

      public function update(Request $request, $id)
      {
          //code
      }

      public function delete($id)
      {
          //code
      }

  }</code></pre>

                <div class="directory"> <i class="fa fa-folder"></i> routes/web.php</div>
<pre><code class="language-php">$router->get('test',[Controllers\Test::class,'index']);
$router->get('create-test',[Controllers\Test::class,'create']);
$router->post('store-test',[Controllers\Test::class,'store']);
$router->get('edit-test/{id}',[Controllers\Test::class,'edit']);
$router->post('update-test/{id}',[Controllers\Test::class,'update']);
$router->get('delete-test/{id}',[Controllers\Test::class,'delete']);</code></pre>

                <h4>Super controller</h4>

                <pre><code class="language-html">php pcode make:controller Test --super</code></pre>

                <p>Tidak jauh berbeda dengan controller sebelumnya, hanya saja jika Anda menggunakan <code>--super</code> akan ada tambahan sample <code>query</code> disetiap method. </p>
                <div class="directory"> <i class="fa fa-folder"></i> controllers/Test.php</div>

                <pre><code class="language-php">&#60;?php 

  namespace Controllers;

  use QB;
  use Rakit\Validation\Validator;
  use Laminas\Diactoros\ServerRequest AS Request;

  class Test
  {

      public function index()
      {

          $data = QB::table('table_name')->get();

          view('path/data', compact('data'));

      }

      public function create()
      {

          view('path/form');

      }

      public function store(Request $request)
      {

          QB::table('table_name')->insert([

              'column' => $request->data

          ]);

          redirect('url');

      }

      public function edit($id)
      {

          $data = QB::table('table_name')->where('id', $id)->first();

          view('path/data', compact('data'));

      }

      public function update(Request $request, $id)
      {

          QB::table('table_name')->where('id', $id)->update([

                'column' => $request->data

          ]);

          redirect('url');

      }

      public function delete($id)
      {

          QB::table('table_name')->where('id', $id)->delete();

          redirect('url');

      }

  }</code></pre> <br>

          <p>Untuk bagian <code>routes/web.php</code> ada sedikit perubahan jika Anda menggunakan <code>--super</code></p>

          <pre><code class="language-php">$router->resource('test',Controllers\Test::class);</code></pre>

          <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>URL</th>
                      <th>Target</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>test</td>
                      <td>Controllers\Test::class, <b>'index'</b> </td>
                  </tr>
                  <tr>
                      <td>create-test</td>
                      <td>Controllers\Test::class, <b>'create'</b> </td>
                  </tr>
                  <tr>
                      <td>store-test</td>
                      <td>Controllers\Test::class, <b>'store'</b> </td>
                  </tr>
                  <tr>
                      <td>edit-test/{id}</td>
                      <td>Controllers\Test::class, <b>'edit'</b> </td>
                  </tr>
                  <tr>
                      <td>update-test/{id}</td>
                      <td>Controllers\Test::class, <b>'update'</b> </td>
                  </tr>
                  <tr>
                      <td>delete-test/{id}</td>
                      <td>Controllers\Test::class, <b>'delete'</b> </td>
                  </tr>
              </tbody>
          </table>

          <hr />
        
      </section>

      <!-- CRUD Sections -->

      <section class="js-section">

        <div class="alert-warning">

            <h1 class="title-section-sidebar">CRUD</h1>
            <p>CRUD adalah singkatan yang berasal dari Create, Read, Update, dan Delete, dimana keempat istilah tersebut merupakan fungsi utama yang nantinya diimplementasikan ke dalam basis data.Empat poin tersebut mengindikasikan bahwa fungsi utama melekat pada penggunaan database relasional beserta aplikasi yang mengelolanya, seperti Oracle, MySQL, SQL Server, dan lain – lain.</p>

        </div>

        <h3 class="section__title">Create</h3>
        <p>Fungsi CRUD yang pertama adalah create, dimana anda dapat memungkinkan untuk membuat record baru pada sistem basis data. Jika anda sering menggunakan SQL, maka sering disebut dengan istilah insert.Sederhananya, anda dapat membuat tabel atau data baru sesuai atribut dengan memanggil fungsi create. Akan tetapi, biasanya hanya posisi administrator saja yang dapat menambahkan atribut lain ke dalam tabel itu sendiri.Fungsi yang kedua adalah read, berarti memungkinkan anda untuk mencari atau mengambil data tertentu yang berada di dalam tabel dengan membaca nilainya. Fungsi read mempunyai kesamaan dengan fungsi search yang biasa anda temukan dalam berbagai perangkat lunak.</p>
        <h4>1. Pembuatan View</h4>
        <p>
            Pastikan Anda sudah mempunyai database, kemudian buat sebuah table dengan nama <code>books</code>, 
            
            <table style="width: 200px !important;">
                <thead>
                    <tr>
                        <td>id</td>
                    </tr>
                    <tr>
                        <td>title</td>
                    </tr>
                    <tr>
                        <td>description</td>
                    </tr>
                    <tr>
                        <td>author</td>
                    </tr>
                </thead>
            </table>
        </p>

        <p>
            Serta pastikan juga project kita sudah terhubung dengan database <code>books</code>, untuk koneksi ke database 
            anda bisa mengatur nya di file <code>.env</code>
        </p>

        <div class="directory"> <i class="fa fa-file"></i> .env</div>

        <pre><code class="language-html"># SETTING PROJECT (TRUE is default)
DEBUG="TRUE"

# SET TRUE IF UPLOAD HOSTING (FALSE is default)
RUN_SERVE="TRUE"

# DATABASE
DB_PORT="3306"
DB_HOST="localhost"
DB_USERNAME="root"
DB_PASSWORD=""
DB_NAME="books"</code></pre>

        <p>kemudian siapkan sebuah view dengan nama form.php di dalam direktori <code>resource/views/book</code></p>

        <div class="alert-warning" style="padding: 0">
            <p style="font-size: 18px; margin-left: 10px;">Untuk langkah-langkah pembuatan view bisa Anda lihat <a href="#view">disini</a></p>
        </div>

        <br>

        <div class="directory"> <i class="fa fa-folder"></i> resources/views/book/form.php</div>

        <pre><code class="language-html"><?php echo htmlspecialchars(file_get_contents('resources/views/component/form.php')) ?></code></pre>

        <h4>2. Setting Route</h4>
        <p>
            Kemudian kita beralih ke direktori <code>routes/web.php</code> untuk mengatur beberapa url rute yang kita butuhkan, <br>
            silahkan Anda ubah menjadi seperti ini.
        </p>
        <div class="directory"> <i class="fa fa-folder"></i> routes/web.php</div>
<pre><code class="language-php">$router->get('books',[Controllers\Books::class,'index']);
$router->get('create-books',[Controllers\Books::class,'create']);
$router->post('store-books',[Controllers\Books::class,'store']);
$router->get('edit-books/{id}',[Controllers\Books::class,'edit']);
$router->post('update-books/{id}',[Controllers\Books::class,'update']);
$router->get('delete-books/{id}',[Controllers\Books::class,'delete']);</code></pre>

        <h4>3. Siapkan Controller</h4>
        <p>
            Sekarang kita akan membuat controller baru dengan nama <b>Books</b>, untuk tutorial pembuatan controller ada <a href="#controller">di sini</a>. <br>
            tambahkan method <u>create & store</u> seperti ini :
        </p>

        <div class="directory"> <i class="fa fa-folder"></i> controllers/Books.php</div>
        <pre><code class="language-php">namespace Controllers;

use QB;
use Rakit\Validation\Validator;
use Laminas\Diactoros\ServerRequest AS Request; 

class Test
{
    public function create()
    {
        view('book/form');
    }

    public function store(Request $request)
    {

        QB::table('books')->insert([

            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author

        ]);

        redirect('create-books');

    }
}</code></pre>
        <h4>4. Jalankan Program</h4>
        <p>Sekarang bisa kita coba untuk menjalankan project dengan cara :</p>

        <pre><code class="language-php">php pcode run</code></pre>

        <p>Kemudian ketik di URL Anda : <b>localhost:8080/create-books</b></p>

        <hr />

      </section>

      <section class="js-section">
        <h3 class="section__title">Read</h3>
        <p>
            Fungsi yang kedua adalah read, berarti memungkinkan anda untuk mencari atau mengambil data tertentu yang berada di dalam tabel dengan membaca nilainya. Fungsi read mempunyai kesamaan dengan fungsi search yang biasa anda temukan dalam berbagai perangkat lunak.
            Hal yang perlu anda lakukan adalah dengan menggunakan kata kunci (keyword) untuk dapat menemukan file record dengan bantuan filter data berdasarkan kriteria tertentu.
        </p>

        <h4>1. Pembuatan View</h4>

        <p>Siapkan sebuah view dengan nama data.php di dalam direktori <code>resource/views/book</code></p>

        <div class="alert-warning" style="padding: 0">
            <p style="font-size: 18px; margin-left: 10px;">Untuk langkah-langkah pembuatan view bisa Anda lihat <a href="#view">disini</a></p>
        </div>

        <br>

        <div class="directory"> <i class="fa fa-folder"></i> resources/views/book/data.php</div>

        <pre><code class="language-html"><?php echo htmlspecialchars(file_get_contents('resources/views/component/data.php')) ?></code></pre>

        <h4>2. Siapkan Controller</h4>
        <p>
            Sekarang kita akan menambahkan method <u>index</u> di controller yang sudah kita buat, tambahkan kode seperti ini :
        </p>

        <div class="directory"> <i class="fa fa-folder"></i> controllers/Books.php</div>
        <pre><code class="language-php">namespace Controllers;

use QB;
use Rakit\Validation\Validator;
use Laminas\Diactoros\ServerRequest AS Request; 

class Test
{

    public function index()
    {
        $data = QB::table('books')->get();
        view('book/form', compact('data'));
    }

    public function create()
    {
        view('book/form');
    }

    public function store(Request $request)
    {

        QB::table('books')->insert([

            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author

        ]);

        redirect('create-books');

    }
}</code></pre>
        <h4>3. Jalankan Program</h4>
        <p>Sekarang bisa kita coba untuk menjalankan project dengan cara :</p>

        <pre><code class="language-php">php pcode run</code></pre>

        <p>Kemudian ketik di URL Anda : <b>localhost:8080/books</b></p>

        <hr />

      </section>

      <section class="js-section">
        <h3 class="section__title">Edit & Update</h3>
        <p>
            Fungsi CRUD yang ketiga adalah update, dimana berfungsi untuk memodifikasi data atau record yang telah tersimpan di dalam database. Namun, anda perlu untuk mengubah beberapa informasi terlebih dahulu agar dapat mengubah record sesuai kebutuhan anda.
            Untuk pengisian update data anda juga perlu menyesuaikan nilai atribut sesuai dengan form yang tersedia agar tidak ada kesalahan saat pemrosesan data di dalam server.
        </p>

        <h4>1. Pembuatan View</h4>

        <p>Siapkan sebuah view dengan nama form-edit.php di dalam direktori <code>resource/views/book</code></p>

        <div class="alert-warning" style="padding: 0">
            <p style="font-size: 18px; margin-left: 10px;">Untuk langkah-langkah pembuatan view bisa Anda lihat <a href="#view">disini</a></p>
        </div>

        <br>

        <div class="directory"> <i class="fa fa-folder"></i> resources/views/book/form-edit.php</div>

        <pre><code class="language-html"><?php echo htmlspecialchars(file_get_contents('resources/views/component/form-edit.php')) ?></code></pre>

        <h4>2. Siapkan Controller</h4>
        <p>
            Sekarang kita akan menambahkan method <u>edit & update</u> di controller yang sudah kita buat, tambahkan kode seperti ini :
        </p>

        <div class="directory"> <i class="fa fa-folder"></i> controllers/Books.php</div>
        <pre><code class="language-php">namespace Controllers;

use QB;
use Rakit\Validation\Validator;
use Laminas\Diactoros\ServerRequest AS Request; 

class Test
{

    public function index()
    {
        $data = QB::table('books')->get();
        view('book/form', compact('data'));
    }

    public function create()
    {
        view('book/form');
    }

    public function store(Request $request)
    {

        QB::table('books')->insert([

            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author

        ]);

        redirect('create-books');

    }

    public function edit($id)
    {
        $data = QB::table('books')->where('id', $id)->first();
        view('book/form-edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        QB::table('books')->where('id', $id)->update([

            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author

        ]);

        redirect('books');

    }

}</code></pre>
        <h4>3. Jalankan Program</h4>
        <p>Sekarang bisa kita coba untuk menjalankan project dengan cara :</p>

        <pre><code class="language-php">php pcode run</code></pre>

        <p>Kemudian ketik di URL Anda : <b>localhost:8080/books</b></p>

        <hr />

      </section>

      <section class="js-section">
        <h3 class="section__title">Delete</h3>
        <p>
            Fungsi yang terakhir adalah delete, dimana ketika anda tidak membutuhkan sebuah record lagi, maka data tersebut perlu untuk dihapus. Sehingga, anda perlu untuk menggunakan fungsi delete untuk memproses aktivitas tersebut.
        </p>

        <h4>1. Siapkan Controller</h4>
        <p>
            Sekarang kita akan menambahkan method <u>delete</u> di controller yang sudah kita buat, tambahkan kode seperti ini :
        </p>

        <div class="directory"> <i class="fa fa-folder"></i> controllers/Books.php</div>
        <pre><code class="language-php">namespace Controllers;

use QB;
use Rakit\Validation\Validator;
use Laminas\Diactoros\ServerRequest AS Request; 

class Test
{

    public function index()
    {
        $data = QB::table('books')->get();
        view('book/form', compact('data'));
    }

    public function create()
    {
        view('book/form');
    }

    public function store(Request $request)
    {

        QB::table('books')->insert([

            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author

        ]);

        redirect('create-books');

    }

    public function edit($id)
    {
        $data = QB::table('books')->where('id', $id)->first();
        view('book/form-edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        QB::table('books')->where('id', $id)->update([

            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author

        ]);

        redirect('books');

    }

    public function delete($id)
    {

        QB::table('books')->where('id', $id)->delete();

        redirect('books');

    }

}</code></pre>
        <h4>2. Jalankan Program</h4>
        <p>Sekarang bisa kita coba untuk menjalankan project dengan cara :</p>

        <pre><code class="language-php">php pcode run</code></pre>

        <p>Kemudian ketik di URL Anda : <b>localhost:8080/books</b></p>

        <hr />

      </section>

      <!-- End CRUD Section -->
    </article>
  </div>



<footer class="footer">Scribbler is a free HTML template created exclusively for <a href="https://tympanus.net/codrops/" target="_blank" class="link link--light">Codrops</a>.</footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
  <script>
    hljs.initHighlightingOnLoad();
  </script>
  <script src="<?php echo htmlentities(asset('js/jquery-3.6.0.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
  <script src="<?php echo htmlentities(asset('js/scripts.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
  <script src="<?php echo htmlentities(asset('js/prism.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
  <script src="<?php echo htmlentities(asset('tree/js/file-explore.js'), ENT_QUOTES, 'UTF-8') ?>"></script> 
  <script src="<?php echo htmlentities(asset('js/scribbler.js'), ENT_QUOTES, 'UTF-8') ?>"></script>

  <script>
    $(document).ready(function() {
      $(".file-tree").filetree();
    });
  </script>
</body>

</html>
