<?php


class EmptyCheckHandler
{
    /**
     * @throws PaymentCornerExceptions
     **/
    public static function onSetAndEmptyCheckHandler($TargetArray, $labelArray, $emptyCheckArray, $handleSpace = 0)
    {

        /*
         * This Function Accepts 5 Different Arguements
         *          $TargetArray -> Array That is to be Analysed (USUAL POST, GET Array)
         *          $labelArray  -> Array Which is passed to Compare for the Array to be Analysed.
         *                          ( It should contain all the required Arguements)
         *          $emptyCheckArray -> Empty check array contains all the elements which are to checked empty against
         *                           the TargetArray, if -1 then all the elements are checked.
         *          EVENT HANDLERS
         *          ---------------------------------------------------------------------------------------------------
         *
         *          $handleSpace   -> If Just space should be checked.
         *
         * */

        $isset = EmptyCheckHandler::isset_value($TargetArray, $labelArray);
        //Array with Variable Names which are Not Set
        if (is_array($isset)) {
            //Some Variables were Not Set
            EmptyCheckHandler::onNotSetHandler($isset);
            //User Specified Function is called When Some Element is Not set
        } else {
            //Variables were set
            $is_empty = EmptyCheckHandler::value_not_empty($TargetArray, $emptyCheckArray, $handleSpace);
            if (is_array($is_empty)) {
                //If some Element of this Array is Empty
                EmptyCheckHandler::onEmptyHandler($is_empty);
                //When Some Element of this Array is Empty
            } else {
                //If None of the Elements in array has an Empty Value
                return true;
                //When The Elements of the array are not empty and when

            }
        }
    }

    public static function isset_value($ArrayToBeChecked, $TargetArray)
    {
        //Check If all the Elements in the Array is set
        //RETURNS TRUE IF EVERY ELEMENT IS TRUE
        //RETURNS AN ARRAY WITH ALL THE ELEMENTS WHICH ARE NOT SET
        /*
         * Profiling Details with xdebug
         * ----------------------------------------------------
         * Execution time => 0.8-1.3 ms when tried with 5 Elements in Target Array and
         * 3 Elements on ArrayToBeChecked, and when Elements are all set
         * Execution time => 1.7-2.0 ms when tried with 5 Elements in TargetArray and
         * 4 Elements on the ArrayToBeChecked, and when 1 Element is not Set.
         *
         * */

        $Boolean_Element_Set_Flag = true;
        $NotSetElementsArray = array();

        foreach ($TargetArray as $ToBeCheckedElement) {
            //Check if all the Elements Are Set
            if (!isset($ArrayToBeChecked[$ToBeCheckedElement])) {
                $Boolean_Element_Set_Flag = false;
                array_push($NotSetElementsArray, $ToBeCheckedElement);
            }
        }

        return (($Boolean_Element_Set_Flag == true) ? true : $NotSetElementsArray);

    }

    public static function value_not_empty($ArrayToBeChecked, $ArrayofElementsWhichisToBeCheckedEmpty, $handleSpace)
    {
        /*
         * Checks to See if Every Array in the Element is not Empty
         * Returns TRUE if every Elements are not Empty
         * Returns the Array With Empty Elements if Some of them are Empty
         *
         * of Comparision Array is -1 then all the value are checked for Empty
         * */
        $Boolean_Element_Empty_Flag = true;
        $EmptyElementsArray = array();
        if (is_array($ArrayofElementsWhichisToBeCheckedEmpty)) {
            foreach ($ArrayofElementsWhichisToBeCheckedEmpty as $key => $Element) {
                if (EmptyCheckHandler::is_blank($ArrayToBeChecked[$Element])) {
                    $Boolean_Element_Empty_Flag = false;
                    array_push($EmptyElementsArray, $key);
                } else if ($handleSpace) {
                    if (strlen(trim($Element)) == 0) {
                        $Boolean_Element_Empty_Flag = false;
                        array_push($EmptyElementsArray, $key);
                    }
                }
            }
        } else if ($ArrayofElementsWhichisToBeCheckedEmpty == -1) {
            /*
             * -1 denotes Check all the Elements
             * */
            foreach ($ArrayToBeChecked as $key => $Element) {

                if (empty($Element)) {
                    $Boolean_Element_Empty_Flag = false;
                    array_push($EmptyElementsArray, $key);
                } else if ($handleSpace) {
                    if (strlen(trim($Element)) == 0) {
                        $Boolean_Element_Empty_Flag = false;
                        array_push($EmptyElementsArray, $key);
                    }
                }
            }
        } else {
            return false;
            //If the Both of the Condition are false then the function returns a false
            //To indicate that its wrong.
        }

        return (($Boolean_Element_Empty_Flag == true) ? true : $EmptyElementsArray);
        //Returns the Element
    }

    private static function is_blank($value)
    {
        return empty($value) && !is_numeric($value);
    }

    /**
     * @throws PaymentCornerExceptions
     **/
    private static function onEmptyHandler()
    {
        throw new PaymentCornerExceptions('Try again with appropriate parameters', 400);

    }

    /**
     * @throws PaymentCornerExceptions
     **/
    private static function onNotSetHandler()
    {
        throw new PaymentCornerExceptions('Try again with appropriate parameters', 400);

    }

}