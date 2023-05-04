<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;


class GameController extends Controller
{
    protected array $game_turns = [];

    public  function turns()
    {
        //validate request
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        //Calculate Game Turns
        $this->calculateGameTurns();

        return response()->json($this->game_turns, 200);
    }

    protected  function calculateGameTurns()
    {
        //accept parameters
        $player = request('first_player') ?? "A";
        $num_of_turns = request('num_of_turns') ?? 3;
        $num_of_players = request('num_of_players') ?? 3;


        //ASCII  code for the max player
        $MaxPlayer  =  $num_of_players + 64;

        $Gameround = 1;

        for ($turn = 0; $turn < $num_of_turns; $turn++) {
            $this->game_turns[$turn] = [];

            if ($Gameround === 1) {
                for ($i = 0; $i < $num_of_players; $i++) {

                    $this->game_turns[$turn][] = $player;
                    $player++;

                    //reset to player to A
                    if (ord($player) > $MaxPlayer) {
                        $player = "A";
                    }
                }
                //next first player
                $player = $this->game_turns[$turn][1];
            } else {
                //reverse each turn
                $this->game_turns[$turn] = array_reverse($this->game_turns[$turn - $num_of_players]);
            }

            //increment round
            if ($turn + 1 === $num_of_players * $Gameround) {
                $Gameround++;
            }
        }
    }


    protected function rules()
    {
        return [
            'num_of_players' => 'lte:26',
        ];
    }
}
