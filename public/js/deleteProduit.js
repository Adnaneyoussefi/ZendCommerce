$(document).ready(() => {
    $('.deleteProduct').click((e) => {
        id = e.currentTarget.getAttribute("value")
        $('.modal-footer a').attr("href", (i, current)=>{
            return current.replace(/\?id=[0-9]*/, '') + '?id=' + id
        })
    })
})