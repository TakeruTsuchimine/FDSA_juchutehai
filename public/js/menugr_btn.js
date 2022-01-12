$(function() {
  let menugr_btns = $(".menugr_btn"); // menugr_btnのクラスを全て取得し、変数menugr_btnsに配列で定義
  $(".menugr_btn").on("click", function() { // menugr_btnをクリックしたらイベント発火
    $(".active").removeClass("active"); // activeクラスを消す
    $(this).addClass("active"); // クリックした箇所にactiveクラスを追加
    const index = menugr_btns.index(this); // クリックした箇所がタブの何番目か判定し、定数indexとして定義
    $(".menu_list").removeClass("show").eq(index).addClass("show"); // showクラスを消して、menu_listクラスのindex番目にshowクラスを追加
  })
});