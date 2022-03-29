<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\SymfonyCigarettePurchaseTransaction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $purchaseTransaction = new SymfonyCigarettePurchaseTransaction($input);
        $cigaretteMachine = new CigaretteMachine();
        $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);

        $output->writeln(
            sprintf(
                'You bought <info>%s</info> packs of cigarettes for <info>%s</info>, each for <info>%s</info>.',
                $purchasedItem->getItemQuantity(),
                $purchasedItem->getTotalAmount(),
                $cigaretteMachine->getItemPrice()
            )
        );
        $output->writeln('Your change is:');
        $change = $purchasedItem->getChange();

        $changeRows = array_map(
            static fn ($coin, $count) => [$coin, $count],
            array_keys($change),
            $change
        );

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($changeRows);
        $table->render();

        return 0;
    }
}
