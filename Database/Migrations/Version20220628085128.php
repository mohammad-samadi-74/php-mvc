<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628085128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $users = $schema->createTable('tokens');

        $users->addColumn('id', 'integer',['unsigned'=>true])->setAutoincrement(true);
        $users->addColumn('user_id', 'integer',['unsigned'=>true]);
        $users->addForeignKeyConstraint('users',["user_id"],['id'],["onDelete" => "CASCADE"]);
        $users->addColumn('token', 'string')->setNotnull(true);
        $users->addColumn('expired_at', Types::DATETIME_IMMUTABLE,['default'=>'CURRENT_TIMESTAMP']);
        $users->setPrimaryKey(['id']);

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tokens');

    }
}
