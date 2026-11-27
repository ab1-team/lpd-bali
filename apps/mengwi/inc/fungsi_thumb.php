<?php
// Upload foto untuk user
function UploadImage_users($newfilename){
  //direktori gambar
  $vdir_upload = "foto_users/";
  $vfile_upload = $vdir_upload . $newfilename;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 200;
  $dst_height2 = 200;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width2,$dst_height2);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im,$vdir_upload . "" . $newfilename);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}
// Upload foto untuk Anggota
function UploadImage_anggota($newfilename){
  //direktori gambar
  $vdir_upload = "foto_anggota/";
  $vfile_upload = $vdir_upload . $newfilename;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 200;
  $dst_height2 = 200;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width2,$dst_height2);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im,$vdir_upload . "" . $newfilename);

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}
?>
