<?php
/**
 * Created by PhpStorm.
 * User: caizhili
 * Date: 15/12/28
 * Time: 下午8:55
 */

require_once("connect_database.php");

$examPaper = "20150601LV4";
$jsonArr["1"] = [];
$jsonArr["1"]["paperNo"] = $examPaper;

//$query = "select * from Choice where ep_No = '{$examPaper}'";

try {
    $db->query("set names 'utf8'");

    $qt_type = $db->query("select qt_No, qt_Type, qt_Directions, qt_AnsScore from QuestionType");
    $qt_type_arr = $qt_type->fetchAll(PDO::FETCH_ASSOC);
    foreach($qt_type_arr as $row) {
        $jsonArr["1"][$row["qt_Type"]]["direction"] = [
            array("intro" => $row["qt_Directions"], "ansScore" => $row["qt_AnsScore"])
        ];

        $sql = "select choice_No, choice_Title, choice_Content from Choice where qt_No = '{$row["qt_No"]}' and ep_No = '{$examPaper}'";
        $titles = $db->query($sql);
        $titles_arr = $titles->fetchAll(PDO::FETCH_ASSOC);

        $jsonArr["1"][$row["qt_Type"]]["options"] = array();
        foreach($titles_arr as $row2) {

            $sql1 = "select co_No, co_Ans, co_Right, co_question, co_A, co_B, co_C, co_D from ChoiceQuestion where choice_No = '{$row2["choice_No"]}'";
            $options = $db->query($sql1);
            $options_arr = $options->fetchAll(PDO::FETCH_ASSOC);

            $aElement = array(
                "choice_Title" => $row2["choice_Title"],
                "choice_Content" => $row2["choice_Content"],
                "question" => $options_arr
            );

            array_push($jsonArr["1"][$row["qt_Type"]]["options"], $aElement);
//            $jsonArr["1"][$row["qt_Type"]]["options"] = [array(
//                "choice_Title" => $row2["choice_Title"],
//                "choice_Content" => $row2["choice_Content"],
//                "question" => $options_arr
//            )];

            //echo json_encode($options_arr);
            //echo "#################################";
        }

        //echo json_encode($jsonArr);
        //echo json_encode($titles_arr);

//        {
//            "co_No": "",
//            "co_Ans": "",
//            "co_Right": "",
//            "co_question": "",
//            "A": "",
//            "B": "",
//            "C": "",
//            "D": ""
//        }
//        {
//            "choice_Title": "",
//        "choice_Content": "",
//        "question": [
//          {
//              "co_No": "",
//            "co_Ans": "",
//            "co_Right": "",
//            "co_question": "",
//            "A": "",
//            "B": "",
//            "C": "",
//            "D": ""
//          }
//        ]
//      }

    }

    echo json_encode($jsonArr);

} catch(PDOException $e) {
    echo $e->getMessage();
}