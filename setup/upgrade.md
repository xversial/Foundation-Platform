## Upgrade

When comes to upgrade Platform to a newer version, you have 2 options, a more manually way, where all the files and folder structure (if applicable) are manually updated or a more automated way, which is by using Git.

This last method brings less work, but it may require a manual validation/patching on some files due to merge conflicts.

The recommended way is by using Git, which is more easier and quick, we also recommend the usage of tools like Git Tower, which simplifies the usage of Git and improves your workflow and also helps this kind of process.

### Preparation

Before starting, you need to make sure that your repository has a remote that points to the `cartalyst/platform` repository.

To achieve this, we just need to add a new [Git Remote](http://www.git-tower.com/learn/git/ebook/command-line/remote-repositories/introduction#start).

To add a new remote just run the following on your terminal:

    $ git remote add upstream git@github.com:cartalyst/platform

> **Note**: You can change `upstream` to something else, like `cartalyst` if you feel it's more easier to remember.

Now that you've the remote added, we can start the upgrade process.

### Upgrade to 3.0 from 2.0

1. Open your terminal and change the current working directory to your local project.

2. Fetch the branches and their commits from the `upstream` remote.

    ```
    $ git fetch upstream
    ```

3. Check out the branch you wish to merge to. This is the branch that contains Platform 2.0 and by default is called `2.0`.

    ```
    $ git checkout 2.0
    ```

4. Pull the 3.0 branch from the upstream repository. This will keep your commit history.

    ```
    $ git merge upstream/3.0
    ```

5. If you have conflicts, you'll need to resolve them. You can get more information [here](https://help.github.com/articles/resolving-a-merge-conflict-from-the-command-line/).

6. Commit the merge

7. You're done :)
