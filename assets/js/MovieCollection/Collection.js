import React          from 'react';
import PropTypes      from 'prop-types';
import {
    Button,
    FormControl,
    FormGroup,
    InputGroup,
    Panel,
    Row
}                     from 'react-bootstrap';
import CollectionItem from "./CollectionItem";

export default function Collection({}) {

    const collectionItems = [
        {
            vote_count       : 1604,
            id               : 9982,
            video            : false,
            vote_average     : 5.8,
            title            : "Chicken Little",
            popularity       : 9.627,
            poster_path      : "/iLMALbInUmbNn1tHmxJEWm5MyjP.jpg",
            original_language: "en",
            original_title   : "Chicken Little",
            genre_ids        : [
                16,
                10751,
                35
            ],
            backdrop_path    : "/9YqNb9V9lded8ZDjMz8nkQLpq15.jpg",
            adult            : false,
            overview         : "When the sky really is falling and sanity has flown the coop, who will rise to save the day? Together with his hysterical band of misfit friends, Chicken Little must hatch a plan to save the planet from alien invasion and prove that the world's biggest hero is a little chicken.",
            release_date     : "2005-11-04"
        },
        {
            vote_count       : 1755,
            id               : 10137,
            video            : false,
            vote_average     : 5.9,
            title            : "Stuart Little",
            popularity       : 8.79,
            poster_path      : "/539JU71suy9q4Wd5vvkKQLl5fTC.jpg",
            original_language: "en",
            original_title   : "Stuart Little",
            genre_ids        : [
                16,
                14,
                10751,
                35
            ],
            backdrop_path    : "/bfiybUiH5TEiuk1Znn2cYG4w0YD.jpg",
            adult            : false,
            overview         : "The adventures of a heroic and debonair stalwart mouse named Stuart Little with human qualities, who faces some comic misadventures while searching for his lost bird friend and living with a human family as their child.",
            release_date     : "1999-12-17"
        },
        {
            vote_count       : 355,
            id               : 1440,
            video            : false,
            vote_average     : 7.1,
            title            : "Little Children",
            popularity       : 8.578,
            poster_path      : "/225OXhGllrBJ6FWaYyiosxDU1us.jpg",
            original_language: "en",
            original_title   : "Little Children on the Prairie",
            genre_ids        : [
                10749,
                18,
                35
            ],
            backdrop_path    : "/5RYylTj1WAO0kVoaY0o3wDfZSpg.jpg",
            adult            : false,
            overview         : "The lives of two lovelorn spouses from separate marriages, a registered sex offender, and a disgraced ex-police officer intersect as they struggle to resist their vulnerabilities and temptations.",
            release_date     : "2006-10-06"
        },
        {
            vote_count       : 473,
            id               : 9072,
            video            : false,
            vote_average     : 5.4,
            title            : "Little Man",
            popularity       : 8.09,
            poster_path      : "/v22zmdXFW44P9l06cH8WCJTYxox.jpg",
            original_language: "en",
            original_title   : "Little Man",
            genre_ids        : [
                35,
                80
            ],
            backdrop_path    : "/5HKGqeWdYxMqP23nR9aalZ2y9AP.jpg",
            adult            : false,
            overview         : "After leaving the prison, the dwarf criminal Calvin Sims joins to his moron brother Percy to steal an expensive huge diamond in a jewelry for the mobster Walken. They are chased by the police, and Calvin hides the stone in the purse of the executive Vanessa Edwards, whose husband Darryl Edwards wants to have a baby. Percy convinces Calvin to dress like a baby and be left in front of the Edwards's house to get inside the house and retrieve the diamond. Darryl and Vanessa keep Calvin for the weekend and decide to adopt him, while Walken threatens Darryl to get the stone back.",
            release_date     : "2006-08-31"
        },
        {
            vote_count       : 415,
            id               : 346671,
            video            : false,
            vote_average     : 5.8,
            title            : "Little Evil",
            popularity       : 7.989,
            poster_path      : "/r3Trvfd5td7JUrIUr5xsDqwNWXJ.jpg",
            original_language: "en",
            original_title   : "Little Evil",
            genre_ids        : [
                35,
                27
            ],
            backdrop_path    : "/8ufJoW3aI2VSFRNr7y1F4ntw21B.jpg",
            adult            : false,
            overview         : "Gary, who has just married Samantha, the woman of his dreams, discovers that her six-year-old son may be the Antichrist.",
            release_date     : "2017-08-08"
        },
        {
            vote_count       : 378,
            id               : 9587,
            video            : false,
            vote_average     : 7.1,
            title            : "Little Women",
            popularity       : 7.921,
            poster_path      : "/tD9YDE8pjtSvvKUpkmooE6YDSm8.jpg",
            original_language: "en",
            original_title   : "Little Women",
            genre_ids        : [
                18,
                10749
            ],
            backdrop_path    : "/iQ1rprz4HCzwhTVxChytbOUtBC5.jpg",
            adult            : false,
            overview         : "With their father away as a chaplain in the Civil War, Jo, Meg, Beth and Amy grow up with their mother in somewhat reduced circumstances. They are a close family who inevitably have their squabbles and tragedies. But the bond holds even when, later, male friends start to become a part of the household.",
            release_date     : "1994-12-21"
        },
        {
            vote_count       : 1562,
            id               : 39451,
            video            : false,
            vote_average     : 5.5,
            title            : "Little Fockers",
            popularity       : 7.186,
            poster_path      : "/qixmjH8fLD9IkboPO7FKxAqzwRJ.jpg",
            original_language: "en",
            original_title   : "Little Fockers",
            genre_ids        : [
                35,
                10749
            ],
            backdrop_path    : "/gpodYxsJZ6OVlpPo0fYkubTBWx9.jpg",
            adult            : false,
            overview         : "It has taken 10 years, two little Fockers with wife Pam and countless hurdles for Greg to finally get in with his tightly wound father-in-law, Jack. After the cash-strapped dad takes a job moonlighting for a drug company, Jack's suspicions about his favorite male nurse come roaring back. When Greg and Pam's entire clan descends for the twins' birthday party, Greg must prove to the skeptical Jack that he's fully capable as the man of the house.",
            release_date     : "2010-12-21"
        },
        {
            vote_count       : 3269,
            id               : 10144,
            video            : false,
            vote_average     : 7.3,
            title            : "The Little Mermaid",
            popularity       : 14.531,
            poster_path      : "/eIFWjrQdig95vJN06xRD34FEBbX.jpg",
            original_language: "en",
            original_title   : "The Little Mermaid",
            genre_ids        : [
                16,
                10751
            ],
            backdrop_path    : "/h62PZCsfuiCD3JvkXmGqrUpnHJL.jpg",
            adult            : false,
            overview         : "This colorful adventure tells the story of an impetuous mermaid princess named Ariel who falls in love with the very human Prince Eric and puts everything on the line for the chance to be with him. Memorable songs and characters -- including the villainous sea witch Ursula.",
            release_date     : "1989-11-17"
        },
        {
            vote_count       : 11,
            id               : 523773,
            video            : false,
            vote_average     : 7.1,
            title            : "Little Italy",
            popularity       : 6.953,
            poster_path      : "/mLhYXQoOpatnbJy9lqWkf7F6Kad.jpg",
            original_language: "en",
            original_title   : "Little Italy",
            genre_ids        : [
                35,
                10749
            ],
            backdrop_path    : "/vb2dKCaQzD48glrAeQIy3IqWILx.jpg",
            adult            : false,
            overview         : "Former childhood pals Leo and Nikki are attracted to each other as adults—but will their feuding parents' rival pizzerias put a chill on their sizzling romance?",
            release_date     : "2018-08-24"
        },
        {
            vote_count       : 85,
            id               : 15138,
            video            : false,
            vote_average     : 5.8,
            title            : "Little Monsters",
            popularity       : 5.851,
            poster_path      : "/3L1yXIoue6WhXwd21deArRkHuOQ.jpg",
            original_language: "en",
            original_title   : "Little Monsters",
            genre_ids        : [
                12,
                14,
                35,
                10751
            ],
            backdrop_path    : "/ngVsWzhqF5Yfppmdeii83HaPuDL.jpg",
            adult            : false,
            overview         : "A young boy is scared of the monster under his bed. He asks his 6th grade brother to swap rooms for the night as a bet that the monster really exists. Soon the brother becomes friends with the monster and discovers a whole new world of fun and games under his bed where pulling pranks on kids and other monsters is the main attraction",
            release_date     : "1989-08-25"
        },
        {
            vote_count       : 252,
            id               : 256962,
            video            : false,
            vote_average     : 7,
            title            : "Little Boy",
            popularity       : 5.65,
            poster_path      : "/6eTWSy0kzsEpeBnlzK18aIO0qSf.jpg",
            original_language: "en",
            original_title   : "Little Boy",
            genre_ids        : [
                35,
                18,
                10752
            ],
            backdrop_path    : "/b18fAocUoEFtjQMHPbFhlxYV0AI.jpg",
            adult            : false,
            overview         : "An eight-year-old boy is willing to do whatever it takes to end World War II so he can bring his father home. The story reveals the indescribable love a father has for his little boy and the love a son has for his father.",
            release_date     : "2015-04-23"
        },
        {
            vote_count       : 126,
            id               : 20726,
            video            : false,
            vote_average     : 6,
            title            : "Little Giants",
            popularity       : 5.547,
            poster_path      : "/33ZN7j6pUhcjbwuQrWTtovrkelx.jpg",
            original_language: "en",
            original_title   : "Little Giants",
            genre_ids        : [
                35,
                10751
            ],
            backdrop_path    : "/h5gb0GR2OeVhXcPOXLY5iaqgQ8m.jpg",
            adult            : false,
            overview         : "When Danny O'Shea's daughter is cut from the Peewee football team just for being a girl, he decides to form his own team, composed of other ragtag players who were also cut. Can his team really learn enough to beat the elite team, coached by his brother, a former pro player?",
            release_date     : "1994-10-14"
        },
        {
            vote_count       : 312,
            id               : 16553,
            video            : false,
            vote_average     : 6.9,
            title            : "Little Manhattan",
            popularity       : 5.529,
            poster_path      : "/1ptpZ9vA73urZykDxnYOnJjMAcS.jpg",
            original_language: "en",
            original_title   : "Little Manhattan",
            genre_ids        : [
                35,
                10749
            ],
            backdrop_path    : "/djifnv4QTD7JsFp4WFK6yLPPvXy.jpg",
            adult            : false,
            overview         : "Ten-year-old Gabe was just a normal kid growing up in Manhattan until Rosemary Telesco walked into his life, actually into his karate class. But before Gabe can tell Rosemary how he feels, she tells him she will not be going to public school any more. Gabe has a lot more to learn about life, love, and girls.",
            release_date     : "2005-09-30"
        },
        {
            vote_count       : 37,
            id               : 385448,
            video            : false,
            vote_average     : 5.5,
            title            : "The Little Mermaid",
            popularity       : 10.633,
            poster_path      : "/qEM80vqREgfjk7YhIbl4AgfZ47S.jpg",
            original_language: "en",
            original_title   : "The Little Mermaid",
            genre_ids        : [
                12,
                14,
                10749,
                18
            ],
            backdrop_path    : "/pfl0ELLHf4wFLBZf2wfceDPnDv5.jpg",
            adult            : false,
            overview         : "A young reporter and his niece discover a beautiful and enchanting creature they believe to be the real little mermaid.",
            release_date     : "2018-08-02"
        }
    ];

    return (
        <div id="my-collection">
            <h2>My Collection</h2>
            <Panel>
                <Panel.Heading>
                    <FormGroup className="mb-0">
                        <InputGroup>
                            <FormControl
                                placeholder="Search My Collection"
                                type="text"
                            />
                            <InputGroup.Button>
                                <Button
                                    bsStyle="info"
                                    type="button"
                                >
                                    <i className="fa fa-search"/>
                                </Button>
                            </InputGroup.Button>
                            <InputGroup.Button>
                                <Button
                                    bsStyle="warning"
                                    type="button"
                                >
                                    <i className="fa fa-eraser"/>
                                </Button>
                            </InputGroup.Button>
                        </InputGroup>
                    </FormGroup>
                </Panel.Heading>
                <Panel.Body className="my-collection">
                    {
                        collectionItems.map((collectionItem, key) =>
                            <CollectionItem
                                collectionItem={ collectionItem }
                                key={ key }
                            />
                        )
                    }
                    <div className="right-box">'</div>
                </Panel.Body>
            </Panel>
        </div>
    );
}

Collection.propTypes = {
    collection: PropTypes.array.isRequired
};
