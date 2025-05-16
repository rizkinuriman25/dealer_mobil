
<hr>

<footer>
    <p>&copy; <?= date('Y') ?> Dealer Mobil XYZ. All rights reserved.</p>
</footer>

</body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    /* Pastikan body dan html mengisi seluruh tinggi layar */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
    }

    /* Wrapper untuk konten utama agar footer tetap di bawah */
    .content {
        flex: 1;
    }

    /* Style untuk footer agar tetap di bawah */
    footer {
        background-color: rgb(44, 79, 86);
        color: #ffffff;
        text-align: center;
        padding: 15px 0;
        font-size: 1rem;
        font-weight: bold;
        width: 100%;
        position: relative;
        bottom: 0;
    }

    /* HR agar senada dengan desain */
    hr {
        border: none;
        height: 3px;
        background-color: rgb(44, 79, 86);
        margin: 20px 0;
    }
</style>
