<?php

use Illuminate\Database\Seeder;

class AgendamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pt_BR');

        $pacientes = App\Paciente::all();
        $medicos = App\Medico::all();
        $clinicas = App\Clinica::all();
        
        for ($i = 0; $i < 500; $i++) 
        {
            $medico = $medicos->random(1);
            $horarios = $medico->horarios;

            $inicio_termino = $this->getInicioETermino($faker, $horarios);             

            try { 
                App\Agendamento::create([
                    'paciente_id' => $pacientes->random(1)->id,
                    'inicio' => $inicio_termino[0],
                    'termino' => $inicio_termino[1],
                    'medico_id' => $medico->id,
                    'clinica_id' => $clinicas->random(1)->id,
                    'status' => $faker->numberBetween($min = 0, $max = 3),
                    'obs' => $faker->optional()->text
                ]);
            } catch( \Exception $e){
                var_dump($e->getMessage());
            }
        }
    }

    public function getInicioETermino($faker, $horarios)
    {
        while(true)
        {
            $inicio = new \Carbon\Carbon($faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years')->format('Y-m-d H:i:00'));

            $inicio->minute = $inicio->minute > 30 ? 30 : 0;

            $horarios_por_dia = $horarios->filter(function($horario) use($inicio) {
                return ($horario->dia_da_semana == $inicio->dayOfWeek);
            });

            foreach($horarios_por_dia as $horario)
            {
                if(hora_entre($inicio, $horario->entrada, $horario->saida))
                {
                    $start = $inicio->format('Y-m-d H:i:s');
                    $end = (rand(0,1) == 0) ? $inicio->addHour()->format('Y-m-d H:i:s') : $inicio->addMinutes(30)->format('Y-m-d H:i:s');
                    
                    if(!hora_menor_que($end, $horario->saida))
                    {
                        $end = $inicio->format('Y-m-d ') .$horario->saida;
                    }

                    return [$start, $end];
                }
            }
        }
    }
}
