# Загрузка картинок D&D, Из окна CKEditor (Image Upload)
 
 - [Версия CKEditor](#ckeditor)
 - [Переопределение файла assets.php](#assets-php)
 - [Настройка конфигурации](#config) 
 - [Настройка кастомного контроллера](#custom-controller) 
 
<a name="ckeditor"></a>
## Скачивание ckeditor
 
 Для начала вам нужно скачать версию ckeditor отсюда [CkEditor Addons](http://ckeditor.com/addons/search/plugins/image).
 
 Плагины которые нам понадобятся называются: `Upload Image (uploadimage)` и `Enchanced Image (image2)`

 Далее вам потребуется добавить свою локализацию, тему и скачать оптимизированную версию CKEditor
 Разместить ее следует в директорию где у вас собираются ассеты в отдельную папку, желательно (public)
 
<a name="assets-php"></a>
## Переопределение файла assets.php
 
 *AppServiceProvider.php*
 ```php
        public function boot()
        {
            ...
    
            if (file_exists($assetsFile = __DIR__ . '/../../resources/assets/admin/assets.php')) {
                include $assetsFile;
            }
            
            ...
        }
 ```
 *assets.php*
 ```php
 <?php
 
 PackageManager::load('ckeditor')
     ->js(null, '/packages/ckeditor/ckeditor.js', ['jquery']); //path to ckeditor.js (in public)
 
 ```
 
<a name="config"></a>
## Настройка Конфигурации
 
 *sleeping_owl.php*
 
 ```php
 'wysiwyg'     => [
         
         ...
         
         'ckeditor'  => [
             'height' => 400,
 
             'toolbarGroups'        => [

                 ....
 
             ],
             ...
             
             'extraPlugins'         => 'uploadimage,image2',
             'uploadUrl'            => '/storage/images_admin', //path to custom controller
             'filebrowserUploadUrl' => '/storage/images_admin', //path to custom controller (for browser ckeditor)
         ],
 
         ...
     ],
 ```
 
<a name="custom-controller"></a>
## Настройка кастомного контроллера
  
  *routes.php* or *admin_routes.php*
  
  ```php
        Route::post('storage/images_admin', [
            'as'   => 'upload.image.s3',
            'uses' => "ImageController@storeAdmin"
        ]);
  ```
  
  *ImageController.php*
  
  ```php
    
    namespace App\Http\Controllers;
    
    use Request;
    use App\Http\Controllers\Controller;
    
    
    class ImageController extends Controller
    {
        /**
         * Method to upload and save images
         * @param Request $request
         * @return string
         */
        public function storeAdmin(Request $request)
        {
            //Your upload logic
    
            $result = [
                'url' => $url_image, 
                'value' => $path_to_image,
                'uploaded' => 1,
                'fileName' => pathinfo($path_to_image, PATHINFO_FILENAME)
            ];
            
            if ($request->CKEditorFuncNum && $request->CKEditor && $request->langCode) {
                //that handler to upload image CKEditor from Dialog
                $funcNum = $request->CKEditorFuncNum;
                $CKEditor = $request->CKEditor;
                $langCode = $request->langCode;
                $token = $request->ckCsrfToken;
                
                return view('helper.ckeditor.upload_file', compact('result', 'funcNum', 'CKEditor', 'langCode', 'token'));
            }
            
            return $result;
        }
    }

  ```
  
  */helper/ckeditor/upload_file.blade.php*
  
  ```php
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Example: File Upload</title>
  </head>
  <body>
  @php
  // Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
  $url = $result['url'];
  // Usually you will only assign something here if the file could not be uploaded.
  $message = 'Some message';
  
  echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url');</script>";
  @endphp
  </body>
  </html>
  ```
  
 ## И да прибудет с вами сила