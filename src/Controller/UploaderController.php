<?php
// src/Controller/UploaderController.php

namespace App\Controller;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Network\Exception\NotFoundException;
use App\Controller\QueryExpression;
use App\Controller\Query;
class UploaderController extends AppController
{
    public function index()
    {
        //$this->loadComponent('Paginator');
        $uploader = null;//$this->Paginator->paginate($this->Articles->find());
        $this->set(compact('uploader'));
    }
    
    public function upload($slug = null)
    {
        $uploadData = '';
        $status = ['status' => 'success'];
        if ($this->request->is('post')) {
            if(!empty($this->request->getData('file')['name'])){
                $fileName = $this->request->getData('file')['name'];
                $uploadPath = WWW_ROOT.'temp/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($this->request->getData('file')['tmp_name'],$uploadFile)){
                }else{
                    //$this->Flash->error(__('Unable to upload file, please try again.'));
                    $status = ['status' => 'fail'];
                }
            }else{
                //$this->Flash->error(__('Please choose a file to upload.'));
            }
        }
        else{
            $status = ['status' => 'no post'];
        }
        $this->set(compact('status'));
    }
    public function save()
    {
        
        $files = $this->request->getData('files');
        $files = json_decode($files);
        $uploadedFiles = [];
        $uploadTmpPath = '/temp/';
        $uploadPath = '/upload/';
        foreach($files as $file){
            $sourceFile = WWW_ROOT.'temp/'.$file->fileName;
            $targetFile = WWW_ROOT.'upload/'.$file->fileName;
            if(file_exists($targetFile) ){
                try{
                    $fileToArchive = $this->Uploader->findByUrl('/upload/'.$file->fileName)->firstOrFail();
                    $newDir = WWW_ROOT.'upload/'.$fileToArchive->id.'/';
                    mkdir($newDir);
                    if (!copy ($targetFile, $newDir.$file->fileName)) {
                        echo "failed to copy ".$targetFile."...\n";
                    }
                    else {
                        $fileToArchive->url = '/upload/'.$fileToArchive->id.'/'.$file->fileName;
                        $this->Uploader->save($fileToArchive);
                        unlink($targetFile);
                    }
                } catch (RecordNotFoundException $e) {

                }
            }
            if(file_exists($sourceFile) ){
                if (!copy ($sourceFile, $targetFile)) {
                    echo "failed to copy ".$sourceFile."...\n";
                }
                else {
                    unlink($sourceFile);
                }
            }
            
            $url = '/upload/'.$file->fileName;
            $newUpload = $this->Uploader->newEntity();
            $newUpload->unique_id = $this->request->getData('unique_id');
            $newUpload->comment = $this->request->getData('comment');
            $newUpload->url = $url;
            $newUpload->alt = $this->request->getData('alt');
            $this->Uploader->save($newUpload);
            $uploadedFiles[] = $newUpload;
        }

        $this->set(compact('uploadedFiles'));
    }
    public function archiveAll()
    {
        $this->loadComponent('Paginator');
        $uploader = $this->Paginator->paginate($this->Uploader->find('all', [
            'order' => ['id' => 'DESC']
        ]));
        $this->set(compact('uploader'));
    }

    public function archiveId()
    {
        $this->loadComponent('Paginator');
        $uploader = $this->Uploader->find();
        $uploader = $this->Paginator->paginate($uploader->distinct(['unique_id']));
        $this->set(compact('uploader'));
    }

    public function view($id = null)
    {
        if($id){
            $file = $this->Uploader->findById($id)->firstOrFail();
            
        $this->set(compact('file'));
        return;
        }
        $unique_id = $this->request->getQuery('unique_id');
        $filename = $this->request->getQuery('filename');
        $limit = $this->request->getQuery('limit');
        $all = $this->request->getQuery('all');
        $file = [];
        $files = $this->Uploader->find('all', [
            'order' => ['id' => 'DESC']
        ])->where([
            'url LIKE' => '%'.$filename,
            'unique_id' => $unique_id
        ])->distinct(['url'])
        ->limit($limit);
        if($all!=1){
            foreach($files as $singleFile){
                $path = explode("/", $singleFile->url);
                if(count($path) < 4){
                    $file[] = $singleFile;
                }
            }
        }
        else{
            $file = $files;
        }
        //var_dump($file);
        $this->set(compact('file'));
    }

    public function viewUniqueId($unique_id = null)
    {
        $files = $this->Uploader->find('all', [
            'order' => ['id' => 'DESC']
        ])->where(['unique_id =' => $unique_id]);
        $this->set(compact('files'));
    }

    public function delete($id, $action)
    {
        $file = $this->Uploader->findById($id)->firstOrFail();
            if(!unlink(WWW_ROOT.$file->url)){

            }
        if ($this->Uploader->delete($file)) {
            $this->Flash->success(__('The {0} file has been deleted.', $file->unique_id));
            return $this->redirect(['action' => $action]);
        }
    }
    public function demo()
    {
        $demo = '';
        if ($this->request->is('post')) {
            if(!empty($this->request->getData('unique_id'))){
                $demo = $this->Uploader->find('all', [
                    'order' => ['id' => 'DESC']
                ])->where(['unique_id =' => $this->request->getData('unique_id')]);
            }
        }
        $this->set(compact('demo'));
    }
    public function api()
    {
    }
}