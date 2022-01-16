<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>趣味一覧画面</title>
</head>
<?php
//ヘッダー読み込み
require_once __DIR__ . '/../header.php';

//htmlspecialcharsの処理
require_once '../util.php';

//締め切り要素をlistDB.phpから取得
require_once 'hobbylistDB.php';

?>
<!-- ここからサイトの表示-->
<h1>趣味一覧 </h1>
<main>

    <form method='POST'>
        <select name='tag'>
            <option value='全て'>全て</option>
            <?php
            //絞り込みができていない
            //tagを取得 
            foreach ($tags as $tag) {
                $tags_list = "<option value='" . h($tag['tag']);
                $tags_list .= "'>" . h($tag['tag']) . "</option>";
                echo $tags_list;
            }
            ?>
        </select>
        <input type='submit' value='送信' />
    </form>
    <!-- ここから締め切りリスト-->
    <table border="1">
        <tr>
            <th>メモ</th>
            <th>タグ</th>
        </tr>

        <?php
        $idcheck = '';
       
        foreach ($tasks as $value) {
            $tagedit=''; 
            $id = $value['id'];
            if ($id != $idcheck) {
        ?>

                <tr>

                    <td><?php echo h($value['memo']); ?></td>
                    <td>
                        <?php

                        foreach ($tasks as $task) {
                            if ($id == $task['id']) {
                                echo h(' '.$task['tag']);
                                if(empty($tagedit)){
                                    $tagedit .=$task['tag'];
                                }else{
                                     $tagedit .= str_replace('#', ' #', $task['tag'] );  
                                }
                              
                            }
                         
                        }
                        ?>
                    </td>
                    <td>
                        <!-- 編集画面edit.phpにデータを送信-->
                        <!-- edit.phpをregister_Deadlineと共有にしたい -->
                        <form action="hobby_edit.php" method="POST">
                            <input type="hidden" name="URL" value="<?= $value['URL']; ?>">
                            <input type="hidden" name="day_at" value="<?= $value['day_at']; ?>">
                            <input type="hidden" name="memo" value="<?= $value['memo']; ?>">
                            <input type="hidden" name="tag" value="<?=  $tagedit  ; ?>">
                            <input type="hidden" name="id" value="<?= $value['id']; ?>">

                            <input type="submit" name="btn" value="編集">
                        </form>
                        <!-- 削除画面delete.phpにデータを送信-->
                        <form action="hobby_delete.php" method="POST">
                            <input type="hidden" name="title" value="<?= $value['memo']; ?>">
                            <input type="hidden" name="day_at" value="<?= $value['day_at']; ?>">
                            <input type="hidden" name="tag" value="<?= $value['tag']; ?>">
                            <input type="hidden" name="id" value="<?= $value['id']; ?>">
                            <input type="submit" name="btn" value="削除">
                        </form>
                    </td>
                </tr>
        <?php
            }
            $idcheck = $id;
        }
        ?>

    </table>
    <!-- //登録画面に遷移 -->
    <a href="./register_Hobby.php">登録</a>
    <script src="../script.js"></script>

</main>