if (document.querySelector(".close-notice")) {
    const closeNotice = document.querySelector(".close-notice");
    closeNotice.addEventListener("click", ()=> {
        closeNotice.parentElement.style.maxHeight = "0px";
        closeNotice.parentElement.style.padding = "0px";
    })
}

if (document.querySelectorAll(".thumbnail > img")) {
   const thumbnails = document.querySelectorAll(".thumbnail > img");
   const popup = document.querySelector(".img-popup");
   const popupImage = document.querySelector(".img-popup > img");
   const closeBtn = document.querySelector(".img-popup .close-img-popup");
   thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener("click", (e)=> {
        popup.style.display = "block";
        popupImage.src = e.target.src;
        closeBtn.style.display = "block";
    })
   }) 
    if(closeBtn) {
        closeBtn.addEventListener("click", (e)=> {
            popup.style.display = "none";
           })
    }
}


