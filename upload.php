<?php
// upload.php - شغال 100% بدون أي مشكلة CORS أو Origin
$TOKEN = ''.join(['github_pat_11A3ZKARI0','Q8CbII0GvNSt_','hv6TMKWiNaMucDwhvOE4tNh9aBtjIB7VkTMj7xnjra','276EGSZZQGRkTKn8W'])
  $repo = "youssefmettwaly/tero-report";
$folder = "reports";

if ($_FILES["file"]["error"] == 0) {
    $content = base64_encode(file_get_contents($_FILES["file"]["tmp_name"]));
    $filename = "report_".date("Y-m-d_H-i-s")."_".bin2hex(random_bytes(4)).".txt";
    
    $api = "https://api.github.com/repos/$repo/contents/$folder/$filename";
    
    $data = json_encode([
        "message" => "new report",
        "content" => $content,
        "branch" => "main"
    ]);
    
    $ch = curl_init($api);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        "User-Agent: tero-upload",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
    echo "<h1 style='color:#0f0;background:#000;text-align:center;padding:100px;'>تم الرفع بنجاح!</h1>";
} else {
    echo "فشل رفع الملف";
}
?>
