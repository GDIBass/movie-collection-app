<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\RawMinkContext;

require_once __DIR__ . '/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * Gets our session
     *
     * @param null $name
     *
     * @return \Behat\Mink\Session
     */
    public function getSession($name = null)
    {
        return $this->getMink()->getSession($name);
    }

    /**
     * Returns the page content
     */
    private function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * @When /^I fill the "(movie|collection)" search with "([A-z0-9 ]*)"$/
     *
     * @param $searchType
     * @param $searchString
     */
    public function iFillTheSearchWith($searchType, $searchString)
    {
        $input = $this->getPage()->find(
            'css',
            sprintf(".search-type-%s", strtolower($searchType))
        );
        assertNotNull(
            $input,
            sprintf("Could not find %s search input", $searchType)
        );
        $input->setValue(
            $searchString
        );
    }


    /**
     * @When /^I press the "(movie|collection)" search( clear)? button$/
     *
     * @param      $searchType
     * @param bool $clear
     */
    public function iPressTheSearchButton($searchType, $clear = false)
    {
        $button = $this->getSearchTypeButton($searchType, $clear);
        $button->click();
    }

    /**
     * @When I wait for the :searchType search to finish
     *
     * @param $searchType
     */
    public function iWaitForTheSearchToFinish($searchType)
    {
        //search-loading-movie
        $this->getSession()->wait(
            5000,
            sprintf(
                "document.querySelectorAll('.search-loading-%s').length === 0",
                strtolower($searchType)
            )
        );
    }

    /**
     * @Then /^the "([A-z]*)" search( clear)? button should( not)? be disabled$/
     *
     * @param      $searchType
     * @param bool $clear
     * @param bool $not
     */
    public function theSearchButtonShouldBeDisabled($searchType, $clear = false, $not = false)
    {
        $button = $this->getSearchTypeButton($searchType, $clear);
        assertEquals(! $not, $button->hasAttribute('disabled'));
    }

    /**
     * Gets a search type button
     *
     * @param      $searchType
     * @param bool $clear
     *
     * @return NodeElement|mixed|null
     */
    private function getSearchTypeButton($searchType, $clear = false)
    {
        $button = $this->getPage()->find(
            'css',
            sprintf(
                '.search-%s-%s',
                $clear ? 'clear' : 'go',
                strtolower($searchType)
            )
        );
        assertNotNull(
            $button,
            sprintf(
                "Could not find %s search%s button",
                $searchType,
                $clear ? ' clear' : ''
            )
        );
        return $button;
    }

    // @formatter:off
    /**
     * @Then /^the toggle button for "([A-z0-9 ]*)" in the "(search|details)" section should( not)? be to add$/
     *
     * @param      $movie
     * @param      $section
     * @param bool $not
     */
    // @formatter:on
    public function theToggleCollectionButtonForInShouldBeToAdd($movie, $section, $not = false)
    {
        $div = $this->getMovieContainerForLocation($movie, $section);

        $button = $div->find('css', 'button');

        assertNotNull($button, "Could not find collection button in container");

        assertEquals($not === false, $button->getAttribute('data-in-collection') === 'false');
    }

    /**
     * @When /^I click the toggle collection button for "([A-z0-9 ]*)" in the "(search|collection|details)" section$/
     *
     * @param $movie
     * @param $section
     */
    public function iClickTheToggleCollectionButtonWithId($movie, $section)
    {
        $div = $this->getMovieContainerForLocation($movie, $section);

        $button = $div->find('css', '.toggle-collection');

        assertNotNull($button, "Could not find collection button in container");

        $button->click();
    }

    /**
     * @When I click the view info button for :movie
     *
     * @param $movie
     */
    public function iClickTheViewInfoButtonFor($movie)
    {
        $div = $this->getMovieContainerForLocation($movie, 'collection');

        $button = $div->find('css', '.collection-item-info');

        assertNotNull($button, "Could not find info button for movie in collection");

        $button->click();
    }

    /**
     * @param $movie
     * @param $section
     *
     * @return NodeElement|mixed|null
     */
    private function getMovieContainerForLocation($movie, $section)
    {
        $div      = null;
        $selector = null;
        if ( $section === 'search' ) {
            $selector = sprintf('.moviedb-result:contains(%s)', $movie);
        } else if ( $section === 'collection' ) {
            $selector = sprintf('.my-collection-item:contains(%s)', $movie);
        } else if ( $section === 'details' ) {
            $selector = '.modal-content';
        } else {
            assertNotNull(null, "Invalid location type: " . $section);
        }

        $div = $this->getPage()->find('css', $selector);
        assertNotNull($div, sprintf("Could not find container for movie %s in section %s", $movie, $section));
        return $div;
    }

    /**
     * @Then /^I wait for "([A-z ]*)" in the "(search|collection|details)" section to finish toggling$/
     *
     * @param $movie
     * @param $section
     */
    public function iWaitForTheInTheSectionToFinishToggling($movie, $section)
    {
        $div = $this->getMovieContainerForLocation($movie, $section);

        $query = 'true';
        if ( $section === 'search' ) {
            $id = $div->getAttribute('data-id');

            assertNotNull($id, "Could not find id from button in container");

            $query = sprintf(
                "document.querySelectorAll('.search-toggle-collection-%s.data-updating').length === 0",
                $id
            );
        } else if ( $section === 'collection' ) {
            $id = $div->getAttribute('data-id');

            assertNotNull($id, "Could not find id from button in container");

            $query = sprintf(
                "document.querySelectorAll('.search-toggle-collection-%s.data-updating').length === 0",
                $id
            );
        } else if ( $section === 'details' ) {
            $query = "document.querySelectorAll('.modal-toggle-collection.data-updating').length === 0";
        }

        $this->getSession()->wait(
            5000,
            $query
        );
    }

    /**
     * Pauses the scenario until the user presses a key. Useful when debugging a scenario.
     *
     * @Then (I )break
     */
    public function iPutABreakpoint()
    {
        fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
        while ( fgets(STDIN, 1024) == '' ) {
        }
        fwrite(STDOUT, "\033[u");
        return;
    }

    /**
     * @When I wait for the modal to load
     */
    public function iWaitForTheModalToLoad()
    {
        $this->getSession()->wait(
            5000,
            "document.querySelectorAll('.modal').length === 1"
        );
        $this->getSession()->wait(100);
    }

    /**
     * @When I wait for the modal to close
     */
    public function iWaitForTheModalToClose()
    {
        $this->getSession()->wait(
            5000,
            "document.querySelectorAll('.modal').length === 0"
        );
        $this->getSession()->wait(100);
    }
}
