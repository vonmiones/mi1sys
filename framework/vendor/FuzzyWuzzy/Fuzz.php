<?php

namespace FuzzyWuzzy;


class Diff_SequenceMatcher
{
    /**
     * @var string|array Either a string or an array containing a callback function to determine if a line is "junk" or not.
     */
    private $junkCallback = null;

    /**
     * @var array The first sequence to compare against.
     */
    private $a = null;

    /**
     * @var array The second sequence.
     */
    private $b = null;

    /**
     * @var array Array of characters that are considered junk from the second sequence. Characters are the array key.
     */
    private $junkDict = array();

    /**
     * @var array Array of indices that do not contain junk elements.
     */
    private $b2j = array();

    private $options = array();

    private $defaultOptions = array(
        'ignoreNewLines' => false,
        'ignoreWhitespace' => false,
        'ignoreCase' => false
    );

    /**
     * The constructor. With the sequences being passed, they'll be set for the
     * sequence matcher and it will perform a basic cleanup & calculate junk
     * elements.
     *
     * @param string|array $a A string or array containing the lines to compare against.
     * @param string|array $b A string or array containing the lines to compare.
     * @param string|array $junkCallback Either an array or string that references a callback function (if there is one) to determine 'junk' characters.
     */
    public function __construct($a, $b, $junkCallback=null, $options)
    {
        $this->a = null;
        $this->b = null;
        $this->junkCallback = $junkCallback;
        $this->setOptions($options);
        $this->setSequences($a, $b);
    }

    public function setOptions($options)
    {
        $this->options = array_merge($this->defaultOptions, $options);
    }

    /**
     * Set the first and second sequences to use with the sequence matcher.
     *
     * @param string|array $a A string or array containing the lines to compare against.
     * @param string|array $b A string or array containing the lines to compare.
     */
    public function setSequences($a, $b)
    {
        $this->setSeq1($a);
        $this->setSeq2($b);
    }

    /**
     * Set the first sequence ($a) and reset any internal caches to indicate that
     * when calling the calculation methods, we need to recalculate them.
     *
     * @param string|array $a The sequence to set as the first sequence.
     */
    public function setSeq1($a)
    {
        if(!is_array($a)) {
            $a = str_split($a);
        }
        if($a == $this->a) {
            return;
        }

        $this->a= $a;
        $this->matchingBlocks = null;
        $this->opCodes = null;
    }

    /**
     * Set the second sequence ($b) and reset any internal caches to indicate that
     * when calling the calculation methods, we need to recalculate them.
     *
     * @param string|array $b The sequence to set as the second sequence.
     */
    public function setSeq2($b)
    {
        if(!is_array($b)) {
            $b = str_split($b);
        }
        if($b == $this->b) {
            return;
        }

        $this->b = $b;
        $this->matchingBlocks = null;
        $this->opCodes = null;
        $this->fullBCount = null;
        $this->chainB();
    }

    /**
     * Generate the internal arrays containing the list of junk and non-junk
     * characters for the second ($b) sequence.
     */
    private function chainB()
    {
        $length = count ($this->b);
        $this->b2j = array();
        $popularDict = array();

        for($i = 0; $i < $length; ++$i) {
            $char = $this->b[$i];
            if(isset($this->b2j[$char])) {
                if($length >= 200 && count($this->b2j[$char]) * 100 > $length) {
                    $popularDict[$char] = 1;
                    unset($this->b2j[$char]);
                }
                else {
                    $this->b2j[$char][] = $i;
                }
            }
            else {
                $this->b2j[$char] = array(
                    $i
                );
            }
        }

        // Remove leftovers
        foreach(array_keys($popularDict) as $char) {
            unset($this->b2j[$char]);
        }

        $this->junkDict = array();
        if(is_callable($this->junkCallback)) {
            foreach(array_keys($popularDict) as $char) {
                if(call_user_func($this->junkCallback, $char)) {
                    $this->junkDict[$char] = 1;
                    unset($popularDict[$char]);
                }
            }

            foreach(array_keys($this->b2j) as $char) {
                if(call_user_func($this->junkCallback, $char)) {
                    $this->junkDict[$char] = 1;
                    unset($this->b2j[$char]);
                }
            }
        }
    }

    /**
     * Checks if a particular character is in the junk dictionary
     * for the list of junk characters.
     *
     * @return boolean $b True if the character is considered junk. False if not.
     */
    private function isBJunk($b)
    {
        if(isset($this->juncDict[$b])) {
            return true;
        }

        return false;
    }

    /**
     * Find the longest matching block in the two sequences, as defined by the
     * lower and upper constraints for each sequence. (for the first sequence,
     * $alo - $ahi and for the second sequence, $blo - $bhi)
     *
     * Essentially, of all of the maximal matching blocks, return the one that
     * startest earliest in $a, and all of those maximal matching blocks that
     * start earliest in $a, return the one that starts earliest in $b.
     *
     * If the junk callback is defined, do the above but with the restriction
     * that the junk element appears in the block. Extend it as far as possible
     * by matching only junk elements in both $a and $b.
     *
     * @param int $alo The lower constraint for the first sequence.
     * @param int $ahi The upper constraint for the first sequence.
     * @param int $blo The lower constraint for the second sequence.
     * @param int $bhi The upper constraint for the second sequence.
     * @return array Array containing the longest match that includes the starting position in $a, start in $b and the length/size.
     */
    public function findLongestMatch($alo, $ahi, $blo, $bhi)
    {
        $a = $this->a;
        $b = $this->b;

        $bestI = $alo;
        $bestJ = $blo;
        $bestSize = 0;

        $j2Len = array();
        $nothing = array();

        for($i = $alo; $i < $ahi; ++$i) {
            $newJ2Len = array();
            $jDict = $this->arrayGetDefault($this->b2j, $a[$i], $nothing);
            foreach($jDict as $jKey => $j) {
                if($j < $blo) {
                    continue;
                }
                else if($j >= $bhi) {
                    break;
                }

                $k = $this->arrayGetDefault($j2Len, $j -1, 0) + 1;
                $newJ2Len[$j] = $k;
                if($k > $bestSize) {
                    $bestI = $i - $k + 1;
                    $bestJ = $j - $k + 1;
                    $bestSize = $k;
                }
            }

            $j2Len = $newJ2Len;
        }

        while($bestI > $alo && $bestJ > $blo && !$this->isBJunk($b[$bestJ - 1]) &&
            !$this->linesAreDifferent($bestI - 1, $bestJ - 1)) {
                --$bestI;
                --$bestJ;
                ++$bestSize;
        }

        while($bestI + $bestSize < $ahi && ($bestJ + $bestSize) < $bhi &&
            !$this->isBJunk($b[$bestJ + $bestSize]) && !$this->linesAreDifferent($bestI + $bestSize, $bestJ + $bestSize)) {
                ++$bestSize;
        }

        while($bestI > $alo && $bestJ > $blo && $this->isBJunk($b[$bestJ - 1]) &&
            !$this->isLineDifferent($bestI - 1, $bestJ - 1)) {
                --$bestI;
                --$bestJ;
                ++$bestSize;
        }

        while($bestI + $bestSize < $ahi && $bestJ + $bestSize < $bhi &&
            $this->isBJunk($b[$bestJ + $bestSize]) && !$this->linesAreDifferent($bestI + $bestSize, $bestJ + $bestSize)) {
                    ++$bestSize;
        }

        return array(
            $bestI,
            $bestJ,
            $bestSize
        );
    }

    /**
     * Check if the two lines at the given indexes are different or not.
     *
     * @param int $aIndex Line number to check against in a.
     * @param int $bIndex Line number to check against in b.
     * @return boolean True if the lines are different and false if not.
     */
    public function linesAreDifferent($aIndex, $bIndex)
    {
        $lineA = $this->a[$aIndex];
        $lineB = $this->b[$bIndex];

        if($this->options['ignoreWhitespace']) {
            $replace = array("\t", ' ');
            $lineA = str_replace($replace, '', $lineA);
            $lineB = str_replace($replace, '', $lineB);
        }

        if($this->options['ignoreCase']) {
            $lineA = strtolower($lineA);
            $lineB = strtolower($lineB);
        }

        if($lineA != $lineB) {
            return true;
        }

        return false;
    }

    /**
     * Return a nested set of arrays for all of the matching sub-sequences
     * in the strings $a and $b.
     *
     * Each block contains the lower constraint of the block in $a, the lower
     * constraint of the block in $b and finally the number of lines that the
     * block continues for.
     *
     * @return array Nested array of the matching blocks, as described by the function.
     */
    public function getMatchingBlocks()
    {
        if(!empty($this->matchingBlocks)) {
            return $this->matchingBlocks;
        }

        $aLength = count($this->a);
        $bLength = count($this->b);

        $queue = array(
            array(
                0,
                $aLength,
                0,
                $bLength
            )
        );

        $matchingBlocks = array();
        while(!empty($queue)) {
            list($alo, $ahi, $blo, $bhi) = array_pop($queue);
            $x = $this->findLongestMatch($alo, $ahi, $blo, $bhi);
            list($i, $j, $k) = $x;
            if($k) {
                $matchingBlocks[] = $x;
                if($alo < $i && $blo < $j) {
                    $queue[] = array(
                        $alo,
                        $i,
                        $blo,
                        $j
                    );
                }

                if($i + $k < $ahi && $j + $k < $bhi) {
                    $queue[] = array(
                        $i + $k,
                        $ahi,
                        $j + $k,
                        $bhi
                    );
                }
            }
        }

        usort($matchingBlocks, array($this, 'tupleSort'));

        $i1 = 0;
        $j1 = 0;
        $k1 = 0;
        $nonAdjacent = array();
        foreach($matchingBlocks as $block) {
            list($i2, $j2, $k2) = $block;
            if($i1 + $k1 == $i2 && $j1 + $k1 == $j2) {
                $k1 += $k2;
            }
            else {
                if($k1) {
                    $nonAdjacent[] = array(
                        $i1,
                        $j1,
                        $k1
                    );
                }

                $i1 = $i2;
                $j1 = $j2;
                $k1 = $k2;
            }
        }

        if($k1) {
            $nonAdjacent[] = array(
                $i1,
                $j1,
                $k1
            );
        }

        $nonAdjacent[] = array(
            $aLength,
            $bLength,
            0
        );

        $this->matchingBlocks = $nonAdjacent;
        return $this->matchingBlocks;
    }

    /**
     * Return a list of all of the opcodes for the differences between the
     * two strings.
     *
     * The nested array returned contains an array describing the opcode
     * which includes:
     * 0 - The type of tag (as described below) for the opcode.
     * 1 - The beginning line in the first sequence.
     * 2 - The end line in the first sequence.
     * 3 - The beginning line in the second sequence.
     * 4 - The end line in the second sequence.
     *
     * The different types of tags include:
     * replace - The string from $i1 to $i2 in $a should be replaced by
     *           the string in $b from $j1 to $j2.
     * delete -  The string in $a from $i1 to $j2 should be deleted.
     * insert -  The string in $b from $j1 to $j2 should be inserted at
     *           $i1 in $a.
     * equal  -  The two strings with the specified ranges are equal.
     *
     * @return array Array of the opcodes describing the differences between the strings.
     */
    public function getOpCodes()
    {
        if(!empty($this->opCodes)) {
            return $this->opCodes;
        }

        $i = 0;
        $j = 0;
        $this->opCodes = array();

        $blocks = $this->getMatchingBlocks();
        foreach($blocks as $block) {
            list($ai, $bj, $size) = $block;
            $tag = '';
            if($i < $ai && $j < $bj) {
                $tag = 'replace';
            }
            else if($i < $ai) {
                $tag = 'delete';
            }
            else if($j < $bj) {
                $tag = 'insert';
            }

            if($tag) {
                $this->opCodes[] = array(
                    $tag,
                    $i,
                    $ai,
                    $j,
                    $bj
                );
            }

            $i = $ai + $size;
            $j = $bj + $size;

            if($size) {
                $this->opCodes[] = array(
                    'equal',
                    $ai,
                    $i,
                    $bj,
                    $j
                );
            }
        }
        return $this->opCodes;
    }

    /**
     * Return a series of nested arrays containing different groups of generated
     * opcodes for the differences between the strings with up to $context lines
     * of surrounding content.
     *
     * Essentially what happens here is any big equal blocks of strings are stripped
     * out, the smaller subsets of changes are then arranged in to their groups.
     * This means that the sequence matcher and diffs do not need to include the full
     * content of the different files but can still provide context as to where the
     * changes are.
     *
     * @param int $context The number of lines of context to provide around the groups.
     * @return array Nested array of all of the grouped opcodes.
     */
    public function getGroupedOpcodes($context=3)
    {
        $opCodes = $this->getOpCodes();
        if(empty($opCodes)) {
            $opCodes = array(
                array(
                    'equal',
                    0,
                    1,
                    0,
                    1
                )
            );
        }

        if($opCodes[0][0] == 'equal') {
            $opCodes[0] = array(
                $opCodes[0][0],
                max($opCodes[0][1], $opCodes[0][2] - $context),
                $opCodes[0][2],
                max($opCodes[0][3], $opCodes[0][4] - $context),
                $opCodes[0][4]
            );
        }

        $lastItem = count($opCodes) - 1;
        if($opCodes[$lastItem][0] == 'equal') {
            list($tag, $i1, $i2, $j1, $j2) = $opCodes[$lastItem];
            $opCodes[$lastItem] = array(
                $tag,
                $i1,
                min($i2, $i1 + $context),
                $j1,
                min($j2, $j1 + $context)
            );
        }

        $maxRange = $context * 2;
        $groups = array();
        $group = array();
        foreach($opCodes as $code) {
            list($tag, $i1, $i2, $j1, $j2) = $code;
            if($tag == 'equal' && $i2 - $i1 > $maxRange) {
                $group[] = array(
                    $tag,
                    $i1,
                    min($i2, $i1 + $context),
                    $j1,
                    min($j2, $j1 + $context)
                );
                $groups[] = $group;
                $group = array();
                $i1 = max($i1, $i2 - $context);
                $j1 = max($j1, $j2 - $context);
            }
            $group[] = array(
                $tag,
                $i1,
                $i2,
                $j1,
                $j2
            );
        }

        if(!empty($group) && !(count($group) == 1 && $group[0][0] == 'equal')) {
            $groups[] = $group;
        }

        return $groups;
    }

    /**
     * Return a measure of the similarity between the two sequences.
     * This will be a float value between 0 and 1.
     *
     * Out of all of the ratio calculation functions, this is the most
     * expensive to call if getMatchingBlocks or getOpCodes is yet to be
     * called. The other calculation methods (quickRatio and realquickRatio)
     * can be used to perform quicker calculations but may be less accurate.
     *
     * The ratio is calculated as (2 * number of matches) / total number of
     * elements in both sequences.
     *
     * @return float The calculated ratio.
     */
    public function Ratio()
    {
        $matches = array_reduce($this->getMatchingBlocks(), array($this, 'ratioReduce'), 0);
        return $this->calculateRatio($matches, count ($this->a) + count ($this->b));
    }

    /**
     * Helper function to calculate the number of matches for Ratio().
     *
     * @param int $sum The running total for the number of matches.
     * @param array $triple Array containing the matching block triple to add to the running total.
     * @return int The new running total for the number of matches.
     */
    private function ratioReduce($sum, $triple)
    {
        return $sum + ($triple[count($triple) - 1]);
    }

    /**
     * Quickly return an upper bound ratio for the similarity of the strings.
     * This is quicker to compute than Ratio().
     *
     * @return float The calculated ratio.
     */
    private function quickRatio()
    {
        if($this->fullBCount === null) {
            $this->fullBCount = array();
            $bLength = count ($b);
            for($i = 0; $i < $bLength; ++$i) {
                $char = $this->b[$i];
                $this->fullBCount[$char] = $this->arrayGetDefault($this->fullBCount, $char, 0) + 1;
            }
        }

        $avail = array();
        $matches = 0;
        $aLength = count ($this->a);
        for($i = 0; $i < $aLength; ++$i) {
            $char = $this->a[$i];
            if(isset($avail[$char])) {
                $numb = $avail[$char];
            }
            else {
                $numb = $this->arrayGetDefault($this->fullBCount, $char, 0);
            }
            $avail[$char] = $numb - 1;
            if($numb > 0) {
                ++$matches;
            }
        }

        $this->calculateRatio($matches, count ($this->a) + count ($this->b));
    }

    /**
     * Return an upper bound ratio really quickly for the similarity of the strings.
     * This is quicker to compute than Ratio() and quickRatio().
     *
     * @return float The calculated ratio.
     */
    private function realquickRatio()
    {
        $aLength = count ($this->a);
        $bLength = count ($this->b);

        return $this->calculateRatio(min($aLength, $bLength), $aLength + $bLength);
    }

    /**
     * Helper function for calculating the ratio to measure similarity for the strings.
     * The ratio is defined as being 2 * (number of matches / total length)
     *
     * @param int $matches The number of matches in the two strings.
     * @param int $length The length of the two strings.
     * @return float The calculated ratio.
     */
    private function calculateRatio($matches, $length=0)
    {
        if($length) {
            return 2 * ($matches / $length);
        }
        else {
            return 1;
        }
    }

    /**
     * Helper function that provides the ability to return the value for a key
     * in an array of it exists, or if it doesn't then return a default value.
     * Essentially cleaner than doing a series of if(isset()) {} else {} calls.
     *
     * @param array $array The array to search.
     * @param string $key The key to check that exists.
     * @param mixed $default The value to return as the default value if the key doesn't exist.
     * @return mixed The value from the array if the key exists or otherwise the default.
     */
    private function arrayGetDefault($array, $key, $default)
    {
        if(isset($array[$key])) {
            return $array[$key];
        }
        else {
            return $default;
        }
    }

    /**
     * Sort an array by the nested arrays it contains. Helper function for getMatchingBlocks
     *
     * @param array $a First array to compare.
     * @param array $b Second array to compare.
     * @return int -1, 0 or 1, as expected by the usort function.
     */
    private function tupleSort($a, $b)
    {
        $max = max(count($a), count($b));
        for($i = 0; $i < $max; ++$i) {
            if($a[$i] < $b[$i]) {
                return -1;
            }
            else if($a[$i] > $b[$i]) {
                return 1;
            }
        }

        if(count($a) == $count($b)) {
            return 0;
        }
        else if(count($a) < count($b)) {
            return -1;
        }
        else {
            return 1;
        }
    }
}

class SequenceMatcher extends Diff_SequenceMatcher
{
    /**
     * SequenceMatcher Constructor.
     *
     * @param array|string $a
     * @param array|string $b
     * @param \Closure|null $junkCallback
     * @param array $options
     */
    public function __construct($a, $b, $junkCallback = null, array $options = [ ])
    {
        parent::__construct($a, $b, $junkCallback, $options);
    }
}


/**
 * A collection of fuzzy string matching algorithms, based on the SeatGeek
 * python library of the same name.
 *
 * @link http://chairnerd.seatgeek.com/fuzzywuzzy-fuzzy-string-matching-in-python/
 *
 * @author Michael Crumm <mike@crumm.net>
 */
class Fuzz
{
    /**
     * Returns a basic ratio score between the two strings.
     *
     * @param string $s1
     * @param string $s2
     *
     * @return integer
     */
    public function ratio($s1, $s2)
    {
        if (null === $s1) { throw new \UnexpectedValueException('s1 is null'); }
        if (null === $s2) { throw new \UnexpectedValueException('s2 is null'); }

        if (strlen($s1) === 0 || strlen($s2) === 0) {
            return 0;
        }

        // $m = new SequenceMatcher($s1, $s2);
        $m = new SequenceMatcher($s1, $s2);

        return Utils::intr(100 * $m->Ratio());
    }

    /**
     *
     * @todo Skip duplicate indexes for a little more speed.
     *
     * @param string $s1
     * @param string $s2
     *
     * @return int
     */
    public function partialRatio($s1, $s2)
    {
        if (null === $s1) { throw new \UnexpectedValueException('s1 is null'); }
        if (null === $s2) { throw new \UnexpectedValueException('s2 is null'); }

        if (strlen($s1) === 0 || strlen($s2) === 0) {
            return 0;
        }

        if (strlen($s1) <= strlen($s2)) {
            $shorter = $s1;
            $longer  = $s2;
        } else {
            $shorter = $s2;
            $longer  = $s1;
        }

        $m = new SequenceMatcher($shorter, $longer);

        $blocks = $m->getMatchingBlocks();
        $scores = [ ];

        foreach ($blocks as $block) {
            $longStart  = $block[1] - $block[0] > 0 ? $block[1] - $block[0] : 0;
            $longEnd    = $longStart + strlen($shorter);
            $longSubstr = substr($longer, $longStart, $longEnd);

            $m2 = new SequenceMatcher($shorter, $longSubstr);
            $r  = $m2->Ratio();

            if ($r > .995) {
                return 100;
            } else {
                $scores[] = $r;
            }
        }

        return Utils::intr(100 * max($scores));
    }

    /**
     * Returns a measure of the sequences' similarity between 0 and 100,
     * using different algorithms.
     *
     * @param string $s1
     * @param string $s2
     * @param boolean $forceAscii
     * @return integer
     */
    public function weightedRatio($s1, $s2, $forceAscii = true)
    {
        $p1 = Utils::fullProcess($s1, $forceAscii);
        $p2 = Utils::fullProcess($s2, $forceAscii);

        if (! Utils::validateString($p1)) {
            return 0;
        }
        if (! Utils::validateString($p2)) {
            return 0;
        }

        # should we look at partials?
        $try_partial   = true;
        $unbase_scale  = .95;
        $partial_scale = .90;

        $base      = $this->ratio($p1, $p2);
        $len_ratio = (float)((max(strlen($p1), strlen($p2))) / min(strlen($p1), strlen($p2)));

        # if strings are similar length, don't use partials
        if ($len_ratio < 1.5) {
            $try_partial = false;
        }

        # if one string is much much shorter than the other
        if ($len_ratio > 8) {
            $partial_scale = .6;
        }

        if ($try_partial) {
            $partial = $this->partialRatio($p1, $p2) * $partial_scale;
            $ptsor = $this->tokenSortPartialRatio($p1, $p2, $forceAscii) * $unbase_scale * $partial_scale;
            $ptser = $this->tokenSetPartialRatio($p1, $p2, $forceAscii) * $unbase_scale * $partial_scale;

            return (int) max($base, $partial, $ptsor, $ptser);
        }

        $tsor = $this->tokenSortRatio($p1, $p2, $forceAscii) * $unbase_scale;
        $tser = $this->tokenSetRatio($p1, $p2, $forceAscii) * $unbase_scale;

        return (int) max($base, $tsor, $tser);
    }

    /**
     * @param $s1
     * @param $s2
     * @param bool $forceAscii
     * @return int|mixed
     */
    public function tokenSetPartialRatio($s1, $s2, $forceAscii = true)
    {
        return $this->tokenSet($s1, $s2, true, $forceAscii);
    }

    /**
     * @param $s1
     * @param $s2
     * @param bool $forceAscii
     * @return int|mixed
     */
    public function tokenSetRatio($s1, $s2, $forceAscii = true)
    {
        return $this->tokenSet($s1, $s2, false, $forceAscii);
    }

    /**
     * @param $s1
     * @param $s2
     * @param bool $forceAscii
     * @return int
     */
    public function tokenSortPartialRatio($s1, $s2, $forceAscii = true)
    {
        return $this->tokenSort($s1, $s2, true, $forceAscii);
    }

    /**
     * @param $s1
     * @param $s2
     * @param bool $forceAscii
     * @return int
     */
    public function tokenSortRatio($s1, $s2, $forceAscii = true)
    {
        return $this->tokenSort($s1, $s2, false, $forceAscii);
    }

    /**
     * Find all alphanumeric tokens in each string...
     *
     * - treat them as a set
     * - construct two strings of the form: <sorted_intersection><sorted_remainder>
     * - take ratios of those two strings
     * - controls for unordered partial matches
     *
     * @param $s1
     * @param $s2
     * @param bool $partial
     * @param bool $forceAscii
     * @return int|mixed
     */
    private function tokenSet($s1, $s2, $partial = true, $forceAscii = true)
    {
        if (null === $s1) { throw new \UnexpectedValueException('s1 is null'); }
        if (null === $s2) { throw new \UnexpectedValueException('s2 is null'); }

        $p1 = Utils::fullProcess($s1, $forceAscii);
        $p2 = Utils::fullProcess($s2, $forceAscii);

        if (!Utils::validateString($p1)) {
            return 0;
        }
        if (!Utils::validateString($p2)) {
            return 0;
        }

        # pull tokens
        $tokens1 = StringProcessor::split(Utils::fullProcess($p1));
        $tokens2 = StringProcessor::split(Utils::fullProcess($p2));

        $intersection = $tokens1->intersection($tokens2);
        $diff1to2     = $tokens1->difference($tokens2);
        $diff2to1     = $tokens2->difference($tokens1);

        $sorted_sect = $intersection->sort()->join();
        $sorted_1to2 = $diff1to2->sort()->join();
        $sorted_2to1 = $diff2to1->sort()->join();

        $combined_1to2 = $sorted_sect . ' ' . $sorted_1to2;
        $combined_2to1 = $sorted_sect . ' ' . $sorted_2to1;

        # strip
        $sorted_sect   = trim($sorted_sect);
        $combined_1to2 = trim($combined_1to2);
        $combined_2to1 = trim($combined_2to1);

        $ratioFunc = (boolean) $partial ? 'partialRatio' : 'ratio';

        $pairwise = [
            call_user_func([$this, $ratioFunc], $sorted_sect, $combined_1to2),
            call_user_func([$this, $ratioFunc], $sorted_sect, $combined_2to1),
            call_user_func([$this, $ratioFunc], $combined_1to2, $combined_2to1)
        ];

        return max($pairwise);
    }

    /**
     * @param $s1
     * @param $s2
     * @param bool $partial
     * @param bool $forceAscii
     * @return int
     */
    private function tokenSort($s1, $s2, $partial = true, $forceAscii = true)
    {
        if (null === $s1) { throw new \UnexpectedValueException('s1 is null'); }
        if (null === $s2) { throw new \UnexpectedValueException('s2 is null'); }

        $sorted1 = $this->processAndSort($s1, $forceAscii);
        $sorted2 = $this->processAndSort($s2, $forceAscii);

        if ((boolean) $partial) {
            return $this->partialRatio($sorted1, $sorted2);
        }

        return $this->ratio($sorted1, $sorted2);
    }

    /**
     * @param string  $str
     * @param boolean $forceAscii
     * @return string
     */
    private function processAndSort($str, $forceAscii = true)
    {
        $tokens = StringProcessor::split(Utils::fullProcess($str, $forceAscii));

        return StringProcessor::strip($tokens->sort()->join());
    }
}
