<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

## Write a function that checks if an inputted value is a palindrome. The function should return true/false (bool).
# You can assume that all input will be a string type and lower case.

/**
 * Determines whether or not a string is a palindrome
 *
 * @param string $input              The string to check
 * @param bool   $excludePunctuation Whether or not punctuation should be excluded
 * @return bool
 */
function is_palindrome(string $input, $excludePunctuation = true): bool
{
    # Remove spaces
    $regex = $excludePunctuation ? '/[.,\/#!$%\^&\*;:{}=\-_`~() ]/' : '/ /';
    $input = preg_replace($regex, '', $input);
    # Note, it's not clear whether or not punctuation should be evaluated.
    #  If they were not expected to be cleared then the above pattern would be replaced with '/ /'

    # i goes up to half the size of the string
    for ( $i = 0; $i < ceil(strlen($input) / 2); $i++ ) {
        # Match a single character in the ith position to the matching character from the end of the string backwards
        if ( substr($input, $i, 1) !== substr($input, 0 - 1 - $i, 1) ) {
            return false;
        }
    }

    return true;
}

$checks = [
    new Check('abcdedcba', true, true),
    new Check('abcdedc!ba', true, true),
    new Check('abcdedc!ba', false, false),
    new Check('abcd!dcba', false, true),
    new Check('abcdeedcba', true, true),
    new Check('abcdefedcba', false, true),
    new Check('a man a plan a canal panama', false, true),
    new ChecK('anamanapea', true, false),
    new Check('asdf%3134#$', true, false),
    new Check('asd%#$%#$dsa', true, true),
    new Check('asd%#$%#$dsa', false, false),
    new Check('!ccc!', false, true),
    new Check('!ccc!c!', true, true),
    new Check('!ccc!c!', false, false),
    new Check('sir, i demand, i am a maid named iris.', false, false),
    new Check('sir, i demand, i am a maid named iris.', true, true)
];

foreach ( $checks as $check ) {
    $result = is_palindrome($check->getString(), $check->getExcludePunctuation());
    echo sprintf("Checking %s : %s %s",
            $check->getString(),
            $result ? 'true' : 'false',
            $result === $check->getExpectedResult() ? '✔️' : '❌'
        ) . PHP_EOL;
}

/**
 * Class Check - For checking stuff, specifically our results
 */
class Check
{
    /** @var string */
    protected $string;
    /** @var bool */
    protected $excludePunctuation;
    /** @var bool */
    protected $expectedResult;

    public function __construct(string $string, bool $excludePunctuation, bool $expectedResult)
    {
        $this->string             = $string;
        $this->excludePunctuation = $excludePunctuation;
        $this->expectedResult     = $expectedResult;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @return bool
     */
    public function getExcludePunctuation(): bool
    {
        return $this->excludePunctuation;
    }

    /**
     * @return bool
     */
    public function getExpectedResult(): bool
    {
        return $this->expectedResult;
    }
}