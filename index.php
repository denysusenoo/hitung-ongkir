<?php
$origins        = include 'origins.php';
$destinations   = include 'destinations.php';
$rate_list      = include 'rate.php';

$origin         = isset( $_GET['origin'] ) ? $_GET['origin'] : '';
$destination    = isset( $_GET['destination'] ) ? $_GET['destination'] : '';
$weight         = isset( $_GET['weight'] ) ? $_GET['weight'] : 1;
$insurance      = isset( $_GET['insurance'] ) ? $_GET['insurance'] : 0;
?>

<h1>Hitung Ongkir</h1>

<form action="" method="get">

    <label for="origin">Kota Asal</label>
    <select name="origin" id="origin" required>
        <option value="">- Pilih Kota Asal -</option>
        <?php foreach ( $origins as $origin_code => $origin_name ) : ?>
            <option value="<?php echo $origin_code ?>" <?php echo $origin_code == $origin ? 'selected="selected"' : '' ?>><?php echo $origin_name ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label for="destination">Kota Tujuan</label>
    <select name="destination" id="destination" required>
        <option value="">- Pilih Kota Tujuan -</option>
        <?php foreach ( $destinations as $destination_code => $destination_name ) : ?>
            <option value="<?php echo $destination_code ?>" <?php echo $destination_code == $destination ? 'selected="selected"' : '' ?>><?php echo $destination_name ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label for="weight">Berat (kg)</label>
    <input type="number" name="weight" id="weight" min="1" value="<?php echo $weight ?>">

    <br><br>

    <input type="checkbox" name="insurance" id="insurance" value="1" <?php echo $insurance == 1 ? 'checked' : '' ?>>
    <label for="insurance">Asuransi (0.25% dari total ongkos kirim)</label>

    <br><br>

    <button type="submit">Hitung</button>

</form>

<?php
$rates = isset( $rate[$origin][$destination] ) ? $rate[$origin][$destination] : [];

if( $rates ) : ?>
    <h4>Ongkir</h4>
    <table style="border: 1px solid black">
        <tr>
            <th style="border: 1px solid black; padding: 5px;">Services</th>
            <th style="border: 1px solid black; padding: 5px;">ETD</th>
            <th style="border: 1px solid black; padding: 5px;">Cost</th>
            <th style="border: 1px solid black; padding: 5px;">Insurance</th>
            <th style="border: 1px solid black; padding: 5px;">Total Cost</th>
        </tr>
        <?php foreach ( $rates as $rate ) : ?>
            <?php
                $cost           = $rate['cost'] * $weight;
                $insurance_cost = $insurance ? $cost * 0.0025 : 0;
                $total          = $cost + $insurance;
                $cost           = 'Rp' . number_format( $cost );
                $insurance_cost = 'Rp' . number_format( $insurance_cost );
                $total          = 'Rp' . number_format( $total );
            ?>
            <tr>
                <td style="border: 1px solid black; padding: 5px;"><?php echo $rate['label'] ?></td>
                <td style="border: 1px solid black; padding: 5px;"><?php echo '(' . $rate['etd'] . ')' ?></td>
                <td style="border: 1px solid black; padding: 5px;"><?php echo $cost ?></td>
                <td style="border: 1px solid black; padding: 5px;"><?php echo $insurance_cost ?></td>
                <td style="border: 1px solid black; padding: 5px;"><?php echo $total ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>

    <?php if( $origin && $destination ) : ?>
        Tidak ada service yang tersedia.
    <?php else : ?>
        Silahkan pilih Kota Asal & Kota Tujuan terlebih dahulu,
    <?php endif; ?>

<?php endif; ?>