<?php
// Default values if not set
$pageTitle = $pageTitle ?? 'SIPP UPTD Puskesmas Ipuh';
$metaDesc = $metaDesc ?? 'Sistem informasi pelayanan publik kesehatan UPTD Puskesmas Ipuh.';
$extraCss = $extraCss ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta name="keywords" content="puskesmas ipuh, pendaftaran online, pelayanan kesehatan, mukomuko, bengkulu">
  <meta name="author" content="UPTD Puskesmas Ipuh">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css?v=1.0">
  <link rel="stylesheet" href="css/navbar.css">
  <?php foreach ($extraCss as $css): ?>
  <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
  <?php endforeach; ?>
  <link rel="stylesheet" href="css/footer.css?v=1.0">
  <?php if(isset($extraHead)) echo $extraHead; ?>
</head>
<body>
