
            <?php
            include 'database.php';
            session_start();
            $sql = "select * from items_list where ITEM_EXIST='true' and USER_ACCOUNT_ID=?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("s", $_SESSION["user_id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                echo " <tr class=\"item_rows \">
                <td colspan='5'>There is no item that is added yet.</td>
            </tr>";
            } else {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr class=\"item_rows \">
                    <td>" . $row["ITEM_ID"] . "</td>
                    <td>" . $row["ITEM_NAME"] . "</td>
                    <td>" . $row["ITEM_DESCRIPTION"] . "</td>
                    <td> &#8369; " . $row["ITEM_PRICE"] . "</td>
                    <td>" . $row["ITEM_ADDED_DATE"] . "</td>
                    </tr>
                    ";
                }
            }
