document.querySelectorAll('table tr').forEach(e => e.addEventListener("click", function(e) {
    let     tr=e.target;
    if(tr.parentNode.classList.contains("highlights"))
    {
        tr.parentNode.classList.remove("highlights")
    }
    else{
        tr.parentNode.classList.add("highlights")
    }
}));