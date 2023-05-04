<?php

namespace Tests\Feature;


use Tests\TestCase;

class GameTest extends TestCase
{
    /**
     *@test
     */
    public function default_turns(): void
    {
        $response =  $this->json('GET', '/api/turns');

        $result = [
            ["A","B","C"],
            ["B","C","A"],
            ["C","A","B"]
        ];

        $this->assertEquals($result, $response->original);
    }


    /**
     * @test
     * @dataProvider provideData
     */
    public function get_game_turns($first_player, $num_of_turns, $num_of_players, $result): void
    {
        $response =  $this->json('GET', '/api/turns', ['first_player' => $first_player, 'num_of_turns' => $num_of_turns, 'num_of_players' => $num_of_players]);

        $this->assertEquals($result, $response->original);
    }


    public function provideData()
    {
        return [
            [
                'first_player' => 'B',
                'num_of_turns' => 15,
                'num_of_players' => 6,
                'result' => [
                    ["B", "C", "D", "E", "F", "A"],
                    ["C", "D", "E", "F", "A", "B"],
                    ["D", "E", "F", "A", "B", "C"],
                    ["E", "F", "A", "B", "C", "D"],
                    ["F", "A", "B", "C", "D", "E"],
                    ["A", "B", "C", "D", "E", "F"],
                    ["A", "F", "E", "D", "C", "B"],
                    ["B", "A", "F", "E", "D", "C"],
                    ["C", "B", "A", "F", "E", "D"],
                    ["D", "C", "B", "A", "F", "E"],
                    ["E", "D", "C", "B", "A", "F"],
                    ["F", "E", "D", "C", "B", "A"],
                    ["B", "C", "D", "E", "F", "A"],
                    ["C", "D", "E", "F", "A", "B"],
                    ["D", "E", "F", "A", "B", "C"]
                ]
            ],
            [
                'first_player' => 'A',
                'num_of_turns' => 6,
                'num_of_players' => 3,
                'result' => [
                    ["A", "B", "C"],
                    ["B", "C", "A"],
                    ["C", "A", "B"],
                    ["C", "B", "A"],
                    ["A", "C", "B"],
                    ["B", "A", "C"]
                ]

            ]
        ];
    }
}
