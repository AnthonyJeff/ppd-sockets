<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resta Um - Chat de Jogo</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body class="bg-img">
    <div class="row">
        <div class="col-md-8">
            <?php include_once 'game/index.php';?>
        </div>

        <div class="col-md-4">
            <div>

                <div id="chat">

                </div>

                <form method="POST" id="frm-chat" class="mb-5">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="hidden" id="txt-user-name" value="<?= strip_tags($_POST['txt-name'] ?? 'User') ?>">
                            <input type="text" id="txt-message" placeholder="Insira sua mensagem aqui." class="form-control w-100">
                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <button type="submit" class="btn btn-outline-success">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./assets/js/chat.js"></script>
</body>

</html>