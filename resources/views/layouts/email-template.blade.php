<style>
    .card {
        float: center;
        background-color: white;
        box-shadow: 0 4px 8px 0 rgba(0,
                0, 0, 0.2);
        max-width: 60%;
        margin: 0 auto;
    }

    .container {
        padding: 2px 16px;
    }

    .footer {
        background-color: #00497f;
        width: 100%;
    }

    .description {
        background-color: #f5f2f2;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        width:
            90%;
        margin: auto;
        padding: 15px;
    }

    .description_text {
        text-align: center;
        font-size: medium;
        color: black;
        word-break: break-all;
    }

    .title {
        margin-top: 10%;
        text-align: center;
        font-family: Georgia, "Times New Roman",
            Times, serif;
        color: #00497f;
        font-size: larger;
    }

    .subtitle {
        text-align:
            center;
        font-size: larger;
        color: black;
    }

    .footer-text {
        color: rgba(255,
                255, 255, 1);
        text-align: center;
    }

    .copyright {
        font-size: small;
    }
</style>
<div class='card'>
    <div class='container'>
        <div class='title'>
            <img src='cid:logo' />
        </div>
        <br />
        <p class='subtitle'>
            Olá, você recebeu uma mensagem de
            <b>{{$name}}</b>
        </p>
        <br />
        <div class='description'>
            <p class='description_text'>"{{$msg}}"</p>
            <br />
            <p class='description_text'>
                <b>Dados de contato:</b><br />
                Email:
                <a href='mailto:{{$email}}'>{{$email}}</a>
            </p>
        </div>
        <br />
        <br />
    </div>
    <div class='footer'>
        <div class='container'>
            <p class="footer-text">© {{date("Y")}} LEB - Laboratório de Etiquetagem de Bombas. Todos os direitos reservados.</p>
        </div>
    </div>
</div>