<?php
$breadcrumbs = array(
    "Home" => "/admin/",
    "Blog" => "/admin/blog/dashboard/"
);
require_once("inc/breadcrumbs.php");
$blog = new Model\Blog();
?>

<h2 class="page-header">Publicações do blog</h2>

<table class="table">
    <thead>
        <th scope="col">Título</th>
        <th scope="col">Data</th>
        <th scope="col" style="width:70px;"></th>
    </thead>
    <tbody>
<?php
$list = $blog->getAll();
foreach($list as $post){
?>
        <tr>
            <td><?php echo $post->getTitle();?></td>
            <td><?php echo $post->getTimestamp()->format('d/m/Y');?></td>
            <td>
                <a href="blog/comments/<?php echo $post->getId();?>/" title="Comentários"><i class="fa fa-comments"></i></a>
                <a href="blog/edit/<?php echo $post->getId();?>/" title="Editar"><i class="fa fa-pencil"></i></a>
                <a href="blog/delete/<?php echo $post->getId();?>/" title="Apagar" class="delete" data-confirm="Deseja realmente apagar esta publicação?"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>