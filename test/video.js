const fileInput = document.querySelector('#chunk');
const btnUpload = document.querySelector('#btn');

btnUpload.addEventListener('click' , handleUploadChunk)

async function handleUploadChunk() {
    const file = fileInput.files[0];
    if(!file){
        return alert('not file contains');
    }
    /**
     * Modifiez le nom du fichier ici
     */
    const oldFile = file.name.split('.');
    const oldName = oldFile[0].replace(' ', '');
    const newName = oldName + '_' + Date.now() + `.${oldFile[1]}`;
    const newFile = new File([file] , newName, {type: file.type , lastModified: file.lastModified});
    const chunkSize = 2 * 1024 * 1024; //10mo
    let start = 0;
    let index = 0;
    
    while(start <= file.size){
        index++;
        await uploadChunk(file.slice(start, start + chunkSize), newFile, 3 , index - 1 , file);
        start+=chunkSize;
    }
}

async function uploadChunk(chunk , file , retries = 3 , index , oldFile){
    const formData = new FormData();
    formData.append('chunk' , chunk);
    let strName = file.name.split('.');
    formData.append('name' , strName[0]);
    formData.append('type' , file.type);
    formData.append('extension' , strName[1]);
    formData.append('size' , oldFile.size);
    formData.append('chunkSize' ,(2* 1024 * 1024).toString());
    formData.append('index' , index);
    try{
        await fetch('http://localhost:8000/api/media_objects/create', {
            method: 'POST',
            body: formData
        });
        console.log('upload success');
    }
    catch (error){
        if(retries > 0){
            await uploadChunk(chunk, retries - 1);
        }else {
            console.error('Failed to upload chunk');
        }
    }
}
