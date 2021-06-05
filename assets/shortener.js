
// $(document).ready(function() {
//     $.datetimepicker.setLocale('en');
//     $('.js-datepicker').datetimepicker({
//         format: 'yyyy-mm-dd'
//     });
// });

let copyButton = document.getElementById("fn_copy_button");
copyButton.onclick = function () {
    let copyText = document.getElementById("fn_short_url_input");
    copyText.select();
    document.execCommand("copy");
    copyText.innerText = copyText.dataset.result_text;
}