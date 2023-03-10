<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<script>
    localStorage.results = '<?= $result ?>';
    localStorage.winner = <?= $winner ?>;
    window.location.replace("../../");
</script>

</body>
</html>
