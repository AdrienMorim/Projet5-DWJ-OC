    // -------------------------------------------------------------
    // Navbar Dashboard
    // -------------------------------------------------------------

    $('.show-all').click(function(e){
        e.preventDefault();
        $('.hide').toggleClass('show');
        $('#chevron-nav').toggleClass('fa-chevron-up');
    })

    // -------------------------------------------------------------
    // Keep Dashboard
    // -------------------------------------------------------------

    const textarea = document.getElementById("keep");

    textarea.addEventListener('change', function(e) {
        textarea.innerHTML = e.target.value;
    });