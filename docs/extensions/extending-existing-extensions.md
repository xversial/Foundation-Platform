## Extending Existing Extensions

Extending existing extensions can be done by simply creating a new extension and registering it under the same uri as the extension you'd like to extend. You'll need to register the extension you're extending in the require array.

### Creating The Extension {#creating-the-extension}

---

You can follow the instructions for creating a new extension [here]({url}/extensions/creating-extensions). There are two things you need to keep in mind: the uri needs to be the same as the extension you're extending and you'll need to list the extension you're extending in the dependencies (or the `require` array if you're creating the extension manually).

### How Does It Work? {#how-does-it-work}

---

What happens is that Platform 2 will cascade through your extensions with the same URI, based on the sequence in which the extensions require each other. Say, for example, that I have an extension B which extends A. I give extension B the same uri as A. Platform 2 will use all of the functionality from A but will override any functionality which you set in B. Platform 2 automatically knows to set B as an endpoint because it's the last to require A.

This works for multiple extensions extending each other as well. Say, for example, that I have an extension C which extends B which extends A. Platform 2 will load C and its custom functionality last because of the hierarchy in which the extensions require one another.
