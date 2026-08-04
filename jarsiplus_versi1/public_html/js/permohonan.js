var formMark1    = document.querySelector('.form-mark-1');
var form1        = document.querySelector('.form-1');
var checkForm1   = document.querySelector('.form-1 #check-form-1');
var btnNextForm1 = document.querySelector('.form-1 .btn-next-form');

var formMark2    = document.querySelector('.form-mark-2');
var form2        = document.querySelector('.form-2');
var checkForm2   = document.querySelector('.form-2 #check-form-2');
var btnPrevForm2 = document.querySelector('.form-2 .btn-prev-form');
var btnNextForm2 = document.querySelector('.form-2 .btn-next-form');

var formMark3    = document.querySelector('.form-mark-3');
var form3        = document.querySelector('.form-3');
var checkForm3   = document.querySelector('.form-3 #check-form-3');
var btnPrevForm3 = document.querySelector('.form-3 .btn-prev-form');
var btnNextForm3 = document.querySelector('.form-3 .btn-next-form');


checkForm1.addEventListener('change', function(){
    if(checkForm1.checked){
        btnNextForm1.removeAttribute('disabled');
    }else{
        btnNextForm1.setAttribute('disabled', 'true');
    }
});

checkForm2.addEventListener('change', function(){
    if(checkForm2.checked){
        btnNextForm2.removeAttribute('disabled');
    }else{
        btnNextForm2.setAttribute('disabled', 'true');
    }
});

checkForm3.addEventListener('change', function(){
    if(checkForm3.checked){
        btnNextForm3.removeAttribute('disabled');
    }else{
        btnNextForm3.setAttribute('disabled', 'true');
    }
});

btnNextForm1.addEventListener('click', function(e){
    e.preventDefault()
    form1.classList.toggle('d-none');
    form2.classList.toggle('d-none');
    formMark1.classList.toggle('active');
    formMark2.classList.toggle('active');
});

btnNextForm2.addEventListener('click', function(e){
    e.preventDefault()
    form2.classList.toggle('d-none');
    form3.classList.toggle('d-none');
    formMark2.classList.toggle('active');
    formMark3.classList.toggle('active');

});

btnPrevForm2.addEventListener('click', function(e){
    e.preventDefault()
    form1.classList.toggle('d-none');
    form2.classList.toggle('d-none');
    formMark1.classList.toggle('active');
    formMark2.classList.toggle('active');
});

btnPrevForm3.addEventListener('click', function(e){
    e.preventDefault()
    form2.classList.toggle('d-none');
    form3.classList.toggle('d-none');
    formMark2.classList.toggle('active');
    formMark3.classList.toggle('active');
});