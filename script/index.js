
const input = document.querySelector('input');

changeToDateListener();

function changeToDateListener(){
    input.addEventListener('input', updateValue);
}

function updateValue(e){
    console.log(e.target.value);
    window.location.href = "index.php?date=" + e.target.value;
}