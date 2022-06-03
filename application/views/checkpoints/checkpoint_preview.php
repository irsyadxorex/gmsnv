<?php if (isset($_POST['preview'])) :
    $n = 1;
    foreach ($checkpoints as $check) : ?>
        <tr>
            <td><?= $n++; ?></td>

            <td><?= indo_date($check['jam']); ?></td>
            <td><?= indo_time($check['jam']); ?></td>
            <td><?= $check['nama']; ?></td>
            <?php if ($this->session->userdata('id_site') == 0) : ?>
                <td><?= $check['site']; ?></td>
            <?php endif ?>
            <td><?= $check['lokasi']; ?></td>
            <!-- <td class="text-center"><?= $check['isclear'] == 1 ? 'kondusif' : 'tidak kondusif'; ?></td> -->
            <td><?= $check['isclear'] == 1 ? 'kondusif' : 'tidak kondusif - ' . $check['note']; ?></td>
        </tr>
<?php endforeach;
endif ?>