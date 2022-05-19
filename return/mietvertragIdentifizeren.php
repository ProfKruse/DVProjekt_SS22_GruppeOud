<?php
echo "Test";
$con =   mysqli_connect("localhost","root","","autovermietung");
if($con->connect_error){
    echo "Fehler bei  der Verbindung" . mysqli_connect_error();
    exit();
}
$sql = "SELECT * FROM mietvertraege";
$db_erg = mysqli_query( $con, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}

echo "<center><table>"
echo"<thead><tr><th>Mietvertragsnummer</th><th>Miete-Anfang</th> <th>Miete-Ende</th><th>Zahlart</th><th>Kosten</th><th>Ausgangszustand</th></tr></thead><tbody>";
while ($zeile = mysqli_fetch_array( $db_erg, MYSQLI_ASSOC))
{
    echo"<tr>
            <td>[$zeile['mietvertragID']</td>
            <td>[$zeile['status']</td>
            <td>[$zeile['mietdauerTage']</td>
            <td>[$zeile['mietgebuehr']</td>
            <td>[$zeile['zahlart']</td>
            <td>[$zeile['tarif']</td>
            <td>[$zeile['abholstation']</td>
            <td>[$zeile['rueckgabestation']</td>
            <td>[$zeile['vertragID']</td>
        </tr>";
}

echo"</tbody>
</table>
</center>";
mysqli_free_result( $db_erg );
mysqli_close($con);
?>