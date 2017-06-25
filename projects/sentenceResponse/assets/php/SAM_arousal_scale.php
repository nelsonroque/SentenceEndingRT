<?php

echo "<h3>How <i>aroused</i> are you feeling now?</h3>";
echo("<div class='check_boxes'>");
echo("<div class='SAMS'>");

echo("<table>");

# img row
echo("<tr>
<td class='SAM_img'><label><img src='./assets/img/SAMS/arousal/arousal_1.JPG' height='75' width='75'></label></td>
<td class='SAM_noimg'><label><img src='./assets/img/spacer.JPG' height='75' width='25'></label></td>
<td class='SAM_img'><label><img src='./assets/img/SAMS/arousal/arousal_3.JPG' height='75' width='75'></label></td>
<td class='SAM_noimg'><label><img src='./assets/img/spacer.JPG' height='75' width='25'></label></td>
<td class='SAM_img'><label><img src='./assets/img/SAMS/arousal/arousal_5.JPG' height='75' width='75'></label></td>
<td class='SAM_noimg'><label><img src='./assets/img/spacer.JPG' height='75' width='25'></label></td>
<td class='SAM_img'><label><img src='./assets/img/SAMS/arousal/arousal_7.JPG' height='75' width='75'></label></td>
<td class='SAM_noimg'><label><img src='./assets/img/spacer.JPG' height='75' width='25'></label></td>
<td class='SAM_img'><label><img src='./assets/img/SAMS/arousal/arousal_9.JPG' height='75' width='75'></label></td>
</tr>");


# button row for labels
echo("<tr>
<td class='SAM_img'><p>4<p></td>
<td class='SAM_noimg'><p>3<p></td>
<td class='SAM_img'><p>2<p></td>
<td class='SAM_noimg'><p>1<p></td>
<td class='SAM_img'><p>0<p></td>
<td class='SAM_noimg'><p>-1<p></td>
<td class='SAM_img'><p>-2<p></td>
<td class='SAM_noimg'><p>-3<p></td>
<td class='SAM_img'><p>-4<p></td>
</tr>");

# button row for arousal
echo("<tr>
<td class='SAM_img'><input type='radio' name='check_list_arousal[]' value='4'></td>
<td class='SAM_noimg'><input type='radio' name='check_list_arousal[]' value='3'></td>
<td class='SAM_img'><input type='radio' name='check_list_arousal[]' value='2'></td>
<td class='SAM_noimg'><input type='radio' name='check_list_arousal[]' value='1'></td>
<td class='SAM_img'><input type='radio' name='check_list_arousal[]' value='0'></td>
<td class='SAM_noimg'><input type='radio' name='check_list_arousal[]' value='-1'></td>
<td class='SAM_img'><input type='radio' name='check_list_arousal[]' value='-2'></td>
<td class='SAM_noimg'><input type='radio' name='check_list_arousal[]' value='-3'></td>
<td class='SAM_img'><input type='radio' name='check_list_arousal[]' value='-4'></td>
</tr>");

echo("</table>");
echo("</div>");

?>