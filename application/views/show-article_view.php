<container>
    <section class='w-50 mx-auto p-2 text-center border-start border-end'>
        <a href="/article">
            <p class='d-inline-block border border-dark text-decoration-none text-dark p-2'>Назад</p>
        </a>
        <h2><?php echo $data['title']; ?></h2>
        <p><?php echo $data['content']; ?></p>
    </section>
    <div class='w-50 mx-auto'><hr></div>
    <section class='w-50 mx-auto p-2 text-center border-start border-end'>
        <h4 class='text-start ps-2'> Комментарии </h4>
        <p></p>
        <div class='input-group pb-2'>
            <form method='post' class='d-flex justify-content-between w-100' id='form-send-message'>
                <input type="hidden" name="author" value="<?php echo $data['login']; ?>" >
                <textarea class="input-group-prepend form-control" rows='3' placeholder='Сообщение' name='message'></textarea>
                <button type="submit" class='btn border border-black' title='Отправить'>Отправить</button>
            </form>
        </div>
    </section>
</container>